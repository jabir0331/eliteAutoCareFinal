<?php

class RegisteredUserHome extends Controller {

    public function index() {
        // Check if user is logged in
        if(!isset($_SESSION['user_id'])) {
            header("Location: " . ROOT . "/Home");
            exit();
        }

        $userId = $_SESSION['user_id'];
        
        // Get user data
        $userModel = new UserModel();
        $user = $userModel->first(['user_id' => $userId]);
        
        // Get vehicles data
        $vehicleModel = new VehicleModel();
        $vehicles = $vehicleModel->where(['user_id' => $userId]);
        
        // Get service history and stats
        $serviceModel = new ServiceBookingModel;
        $serviceCount = 0;
        $nextServiceDays = null;
        $nextBookingDate = null;
        $serviceHistory = [];
        
        if($serviceModel) {
            // Count total services
            $result = $serviceModel->Where(['user_id' => $userId]);
            if($result){
                $serviceCount = count($result);
            }
            else{
                $serviceCount = 0;
            }
            
            // Get next booking
            // $nextBooking = $serviceModel->getNextBooking($userId);
            // if($nextBooking) {
            //     $nextBookingDate = $nextBooking->service_date;
            //     $nextServiceDays = $this->calculateDaysRemaining($nextBookingDate);
            // }
            
            // Get service history for chart
            // $serviceHistory = $serviceModel->getServiceHistoryByMonth($userId);
            
            // Calculate days to service for each vehicle
            // if(!empty($vehicles)) {
            //     foreach($vehicles as &$vehicle) {
            //         $vehicle->days_to_service = $this->calculateDaysToNextService($vehicle);
            //     }
            // }
        }
        
        // Prepare data for view
        $data = [
            'user' => $user,
            'vehicles' => $vehicles,
            'serviceCount' => $serviceCount,
            'nextServiceDays' => $nextServiceDays,
            'nextBookingDate' => $nextBookingDate,
            'serviceHistory' => $serviceHistory
        ];
        
        $this->view('registeredUserHome', $data);
    }
    
    /**
     * Calculate days until next recommended service based on last service date
     * Typically services are recommended every 6 months
     */
    private function calculateDaysToNextService($vehicle) {
        if(empty($vehicle->last_serviced_date)) {
            return null;
        }
        
        $lastServiceDate = strtotime($vehicle->last_serviced_date);
        $nextServiceDate = strtotime('+6 months', $lastServiceDate);
        $today = time();
        
        return floor(($nextServiceDate - $today) / (60 * 60 * 24));
    }
    
    /**
     * Calculate days remaining until a specific date
     */
    private function calculateDaysRemaining($date) {
        $targetDate = strtotime($date);
        $today = time();
        
        return floor(($targetDate - $today) / (60 * 60 * 24));
    }
}