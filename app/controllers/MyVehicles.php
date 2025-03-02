<?php

class MyVehicles extends Controller
{

    private $vehicleModel;
    private $user_id;

    public function __construct()
    {
        $this->vehicleModel = new VehicleModel();

        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            redirect('Home');
        }

        $this->user_id = $_SESSION['user_id'];
    }

    public function index()
    {
        // Get all vehicles for the current user
        $vehicles = $this->vehicleModel->where(['user_id' => $this->user_id]);

        $data['vehicles'] = $vehicles;
        $this->view('myVehicles', $data);
    }

    public function getVehicle($id = null)
    {
        if (!$id) {
            $response = [
                'status' => 'error',
                'message' => 'Vehicle ID is required'
            ];
            echo json_encode($response);
            return;
        }

        // Get vehicle details
        $vehicle = $this->vehicleModel->first([
            'vehicle_id' => $id,
            'user_id' => $this->user_id
        ]);

        if (!$vehicle) {
            $response = [
                'status' => 'error',
                'message' => 'Vehicle not found'
            ];
            echo json_encode($response);
            return;
        }

        $response = [
            'status' => 'success',
            'data' => $vehicle
        ];

        echo json_encode($response);
    }

    private function handleProfilePicUpload() {
        if (isset($_FILES['vehicleImage']) && $_FILES['vehicleImage']['error'] === UPLOAD_ERR_OK) {
            // Log upload attempt for debugging
            error_log("Attempting to upload vehicle image: " . $_FILES['vehicleImage']['name']);
            
            // Define upload directory - should match the path used in the view
            $uploadDir = uploads . '/vehicles/';
            
            // Ensure the directory exists
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
                error_log("Created directory: " . $uploadDir);
            }
            
            // Generate a unique filename
            $fileName = uniqid() . '_' . basename($_FILES['vehicleImage']['name']);
            
            // Full path for the uploaded file
            $uploadPath = $uploadDir . $fileName;
            
            error_log("Attempting to move uploaded file to: " . $uploadPath);
            
            // Move uploaded file
            if (move_uploaded_file($_FILES['vehicleImage']['tmp_name'], $uploadPath)) {
                error_log("File uploaded successfully");
                // Return just the filename to be stored in the database
                return $fileName;
            } else {
                // Add detailed error logging
                error_log("File upload failed. Error code: " . $_FILES['vehicleImage']['error']);
                error_log("Upload path: " . $uploadPath);
                error_log("Temp path: " . $_FILES['vehicleImage']['tmp_name']);
                error_log("Directory writable: " . (is_writable($uploadDir) ? 'Yes' : 'No'));
                error_log("PHP Error: " . error_get_last()['message']);
            }
        } else if (isset($_FILES['vehicleImage'])) {
            error_log("Vehicle image upload error: " . $_FILES['vehicleImage']['error']);
        } else {
            error_log("No vehicleImage in FILES array");
            error_log("FILES array contents: " . print_r($_FILES, true));
        }
    
        return null;
    }


    /*This function handles both the insertion and updations of the vehicles */
    public function saveVehicle()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $mode = $_POST['mode'];
            $vehicleId = $_POST['vehicleId'] ?? '';

            $formData = [
                'user_id' => $this->user_id,
                'make' => $_POST['make'] ?? '',
                'model' => $_POST['model'] ?? '',
                'vehicle_make_year' => $_POST['year'] ?? '',
                'last_serviced_mileage' => $_POST['mileage'] ?? '',
                'vehicle_status' => 'active'
            ];

            $uploadedImagePath = $this->handleProfilePicUpload();

            if ($uploadedImagePath) {
                $formData['vehicle_img_path'] = $uploadedImagePath;
            }

            if($mode == 'insertMode'){

                // For insert, include plate number
                $formData['plate_number'] = $_POST['plate_number'] ?? '';

                // Validate data
                $errors = $this->vehicleModel->validate($formData);

                if (!empty($errors)) {
                    $data['errors'] = $errors;
                    $data['vehicles'] = $this->vehicleModel->where(['user_id' => $this->user_id]);
                    $this->view('myVehicles', $data);
                    return;
                }

                $result = $this->vehicleModel->insert($formData);
            }
            
            else if($mode == 'updateMode'){

                // Validate data
                $errors = $this->vehicleModel->validate($formData, $vehicleId);

                if (!empty($errors)) {
                    $data['errors'] = $errors;
                    $data['vehicles'] = $this->vehicleModel->where(['user_id' => $this->user_id]);
                    $this->view('myVehicles', $data);
                    return;
                }

                $result = $this->vehicleModel->update($vehicleId , $formData, 'vehicle_id');
            }

            // Save to databas
            if ($result) {
                redirect('MyVehicles');
            } 
            else {
                $data['errors'] = ['db_error' => 'Failed to save vehicle'];
                $data['vehicles'] = $this->vehicleModel->where(['user_id' => $this->user_id]);
                $this->view('myVehicles', $data);
            }
        } 
        else {
            redirect('MyVehicles');
        }
    }

    public function deleteVehicle()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $vehicle_id = $_POST['vehicle_id_holder'];

        $vehicle = $this->vehicleModel->first([
            'vehicle_id' => $vehicle_id,
            'user_id' => $this->user_id
        ]);

        if(!$vehicle){
            $data['errors'] = ["Vehicle not found!"];
            $data['vehicles'] = $this->vehicleModel->where(['user_id' => $this->user_id]);
            $this->view('myVehicles', $data);
            return;
        }

        $result = $this->vehicleModel->delete($vehicle_id, 'vehicle_id');

        if(!$result){
            $data['errors'] = ["Vehicle deletion failed!"];
            $data['vehicles'] = $this->vehicleModel->where(['user_id' => $this->user_id]);
            $this->view('myVehicles', $data);
            return;
        }

        redirect('MyVehicles');
        return;
    }
    else{
        redirect('MyVehicles');
        return;
    }
}
    
}
