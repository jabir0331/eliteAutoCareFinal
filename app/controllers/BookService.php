<?php

class BookService extends Controller {
    public function index() {
        // Check if user is logged in
        if(!isset($_SESSION['user_id'])) {
            header("Location: " . ROOT . "/Home");
            exit();
        }
    
        $userId = $_SESSION['user_id'];
    
        $vehicleModel = new VehicleModel();
        $serviceBookingModel = new ServiceBookingModel;
    
        $vehicles = $vehicleModel->where(['user_id' => $userId]);
    
        if(empty($vehicles)) {
            // No vehicles found, redirect to add vehicle page with a message
            $_SESSION['message'] = "You need to add a vehicle before booking a service";
            header("Location: " . ROOT . "/MyVehicles");
            exit();
        } 
        else {
            $hasServiceBookings = false;
            
            foreach($vehicles as $key => $vehicle) {
                $result = $serviceBookingModel->where(
                    ['user_id' => $userId, 'vehicle_id' => $vehicle->vehicle_id], 
                    [
                        'order_by' => 'service_date',
                        'order_type' => 'DESC'
                    ]
                );
    
                if(!empty($result)) {
                    $lastServiceDate = $result[0]->service_date;
                    $vehicles[$key]->lastServiceDate = $lastServiceDate;
                    $hasServiceBookings = true;
                } else {
                    // Handle case where vehicle exists but has no service bookings
                    $vehicles[$key]->lastServiceDate = null;
                }
            }
            
            $data['vehicles'] = $vehicles;
            
            // Add flag to indicate if any service bookings were found
            $data['hasServiceBookings'] = $hasServiceBookings;
            
            // Optionally add a message if no service bookings were found
            if (!$hasServiceBookings) {
                $data['message'] = "You haven't booked any services yet";
            }
        }
    
        $this->view('bookService', $data);
    }

    public function getRecommendations() {
        header('Content-Type: application/json');
        
        try {
            if(!isset($_POST['mileage'])) {
                throw new Exception("Missing mileage parameter");
            }
            
            $currentMileage = intval($_POST['mileage']);
            $lastMileage = isset($_POST['lastMileage']) ? intval($_POST['lastMileage']) : 0;
            
            if ($currentMileage <= 0) {
                throw new Exception("Invalid mileage value");
            }
            
            if ($currentMileage < $lastMileage) {
                throw new Exception("Current mileage must be greater than or equal to last service mileage");
            }
            
            $mileageDifference = $currentMileage - $lastMileage;
            
            $aiResponse = $this->getAIRecommendations($currentMileage, $mileageDifference);
            $responseData = json_decode($aiResponse, true);
    
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("Failed to parse AI response: " . json_last_error_msg());
            }
    
            if (!isset($responseData['choices'][0]['message']['content'])) {
                throw new Exception("Unexpected API response format");
            }
    
            $aiMessage = $responseData['choices'][0]['message']['content'];
            
            // Try to parse the JSON from the AI's response
            // First, check if the response already is valid JSON
            $services = json_decode($aiMessage, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                // If not, try to extract JSON from text response
                preg_match('/\[.*\]/s', $aiMessage, $matches);
                
                if (empty($matches)) {
                    throw new Exception("Could not extract service recommendations from AI response");
                }
    
                $servicesJson = $matches[0];
                $services = json_decode($servicesJson, true);
    
                if (json_last_error() !== JSON_ERROR_NONE) {
                    throw new Exception("Invalid JSON in service recommendations");
                }
            }
            
            // Validate and clean up service prices
            foreach ($services as &$service) {
                // Check if price exists
                if (!isset($service['price'])) {
                    // Look for price in the reason field as fallback
                    if (preg_match('/(\d{1,3}(,\d{3})*|\d+)(\s*-\s*\d{1,3}(,\d{3})*|\d+)?\s*(?:LKR|Rs\.?|Rupees)/i', $service['reason'], $matches)) {
                        // Extract numeric part
                        $price = preg_replace('/[^0-9]/', '', $matches[0]);
                        $service['price'] = intval($price);
                    } else {
                        // Assign default price based on priority
                        switch (strtolower($service['priority'])) {
                            case 'high':
                                $service['price'] = 15000;
                                break;
                            case 'medium':
                                $service['price'] = 8000;
                                break;
                            case 'low':
                                $service['price'] = 3000;
                                break;
                            default:
                                $service['price'] = 5000;
                        }
                    }
                } else if (is_string($service['price'])) {
                    // If price is a string, clean it to just the number
                    $service['price'] = preg_replace('/[^0-9]/', '', $service['price']);
                    $service['price'] = intval($service['price']);
                    
                    // If still zero or invalid, assign default
                    if ($service['price'] <= 0) {
                        $service['price'] = 5000; // Default fallback
                    }
                }
            }
            
            // Add a flag for small mileage difference
            $isSmallMileageDifference = ($mileageDifference < 100);
    
            echo json_encode([
                'success' => true,
                'data' => $services,
                'isSmallMileageDifference' => $isSmallMileageDifference,
                'mileageDifference' => $mileageDifference
            ]);
    
        } catch (Exception $e) {
            $this->logError("Recommendation Error", ["message" => $e->getMessage()]);
            echo json_encode([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
        exit;
    }

    private function getAIRecommendations($currentMileage, $mileageDifference) {
    $apiKey = "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";
    $url = "https://openrouter.ai/api/v1/chat/completions";
    
    // Handle edge cases with very small mileage differences
    if ($mileageDifference < 100) {
        $prompt =   "A vehicle owner has reported their current mileage as {$currentMileage}km, 
                    which is only {$mileageDifference}km since their last recorded service. 
                    This could be a data entry error or the vehicle might have just been serviced recently.
                    If this is likely a data entry error, suggest they verify their mileage readings. 
                    If it's a recent service, recommend only inspection services.

                    Please format your response as a JSON array with each recommendation having these EXACT fields: 
                    - \"name\": (service name)
                    - \"priority\": (must be only \"high\", \"medium\", or \"low\")
                    - \"reason\": (explanation referencing the small {$mileageDifference}km situation)
                    - \"price\": (estimated cost in Lankan Rupees, formatted as a number without currency symbol, 
                    range between 1,000-50,000 LKR depending on service)

                    Include both possibilities in your response (data error and valid reading).";
    } else {
        // Normal case for significant mileage differences
        $prompt =   "Given a vehicle with current mileage of {$currentMileage}km and {$mileageDifference}km driven since the last service, 
                    what maintenance services would you recommend?

                    Consider the following factors:
                    1. Typical service intervals (oil changes: 5,000km, filters: 10,000km, etc.)
                    2. Current mileage milestone recommendations (e.g., timing belt at 100,000km)
                    3. The distance driven since last service ({$mileageDifference}km)

                    Please format your response as a JSON array with each service having these EXACT fields:
                    - \"name\": (service name)
                    - \"priority\": (must be only \"high\", \"medium\", or \"low\")
                    - \"reason\": (explanation referencing the {$mileageDifference}km driven)
                    - \"price\": (estimated cost in Lankan Rupees, formatted as a number without currency symbol, range between 1,000-50,000 LKR depending on service)

                    Here are some typical service prices in Sri Lanka to reference:
                    - Basic oil change: 5,000-8,000 LKR
                    - Full service: 15,000-25,000 LKR
                    - Brake pad replacement: 8,000-12,000 LKR
                    - Air filter replacement: 3,000-5,000 LKR
                    - Fuel filter replacement: 5,000-7,000 LKR
                    - Timing belt replacement: 20,000-35,000 LKR

                    Provide 3-4 most important services based on this information. Include ONLY the JSON array in your response - no additional explanations.";
    }
    
    $data = [
        "model" => "cognitivecomputations/dolphin3.0-r1-mistral-24b:free",
        "messages" => [
            ["role" => "system", "content" => "You are an automotive service advisor AI specialized in Sri Lankan vehicle maintenance. You provide specific, actionable maintenance recommendations in JSON format. ALWAYS include price estimates in Lankan Rupees (LKR). Always respond with properly formatted JSON array that can be parsed by PHP's json_decode(). Each recommendation must include name, priority, reason, and price fields."],
            ["role" => "user", "content" => $prompt]
        ]
    ];

    $headers = [
        "Content-Type: application/json",
        "Authorization: Bearer " . $apiKey,
        "HTTP-Referer: http://localhost", // Update this with your actual domain
        "X-Title: EliteAutoCare"
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    
    // Add SSL verification options
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

    $response = curl_exec($ch);
    
    // Check for cURL errors
    if(curl_errno($ch)) {
        $this->logError("cURL Error: " . curl_error($ch));
        throw new Exception("Failed to connect to AI service: " . curl_error($ch));
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Check HTTP response code
    if ($httpCode !== 200) {
        $this->logError("API Error", ["httpCode" => $httpCode, "response" => $response]);
        throw new Exception("API request failed with code: " . $httpCode);
    }

    return $response;
}
    
    private function logError($message, $data = null) {
        error_log("Elite Auto Care Error: " . $message . ($data ? " Data: " . json_encode($data) : ""));
    }
}