<?php 
    class VehicleModel{
        use Model;

        protected $table = 'vehicles'; 

        protected $allowedColumns = [
            'vehicle_id',
            'user_id',
            'make',
            'model',
            'plate_number',
            'vehicle_make_year',
            'last_serviced_mileage',
            'vehicle_img_path',
            'vehicle_status'
        ];

        public function checkExistingVehicle($plateNum)
        {
            $result = $this->first(['plate_number' => $plateNum]);
            return !empty($result);
        }

        public function validate($data, $vehicleId = null){
            $errors = [];
        
            // Validate make
            if (empty($data['make'])) {
                $errors['make'] = "Car make is required.";
            }
        
            // Validate model
            if (empty($data['model'])) {
                $errors['model'] = "Car model is required.";
            }
        
            // Validate plate number
            if($vehicleId == null){
                if (empty($data['plate_number'])) {
                    $errors['plate_number'] = "License plate number is required.";
                }
                elseif (!preg_match('/^[A-Z]{2,3}-\d{4}$/', $data['plate_number'])) {
                    $errors['plate_number'] = "License plate must be in format: CAR-1234";
                }
                elseif ($this->checkExistingVehicle($data['plate_number'])) {
                    $errors['plate_number'] = "Plate number " . $data['plate_number'] . "  is already registered.";
                }
            }
             
        
            return $errors;
        }


    }


