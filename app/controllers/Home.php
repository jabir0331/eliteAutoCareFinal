<?php

    class Home extends Controller{

        public function index(){     
            
            $this->view('unregisteredUserHome');
        }

        public function userSignup(){
            // Initialize error array
            $errors = []; // Changed to plural for consistency
        
            // Check if the form is submitted
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Get form data
                $userData = [
                    'email' => $_POST['email'],
                    'password' => $_POST['password'],
                    'confirmPassword' => $_POST['confirmPassword']
                ];
        
                $vehicleData = [
                    'make' => $_POST['make'],
                    'model' => $_POST['model'],
                    'plate_number' => $_POST['plateNum']
                ];
        
                $user = new UserModel;
                $vehicle = new VehicleModel;
        
                $userErrors = $user->validate($userData);
                $vehicleErrors = $vehicle->validate($vehicleData);
                
                // Combine errors from both validations
                $errors = array_merge($userErrors, $vehicleErrors);
        
                if(empty($errors)){
                    // Hash the password
                    $hashedPassword = password_hash($userData['password'], PASSWORD_DEFAULT);
                    $userData['password'] = $hashedPassword;
                    
                    // Remove confirmPassword as it's not in allowedColumns
                    unset($userData['confirmPassword']);
        
                    $user_id = $user->insert($userData);
        
                    if($user_id){
                        $_SESSION['user_id'] = $user_id;
                        $vehicleData['user_id'] = $user_id;
                        
                        $vehicle_id = $vehicle->insert($vehicleData);
                        
                        if($vehicle_id){
                            header("Location: " . ROOT . "/RegisteredUserHome");
                            exit;
                        }
                        else {
                            $errors["vehicle_error"] = "Failed to add vehicle details!";
                        }
                    }
                    else{
                        $errors["user_error"] = "Failed to create user account!";
                    }
                }
                
                $errors['errorType'] = 'signUpErrors';
                $this->view('unregisteredUserHome', ['errors' => $errors]);
            }
            else{
                $this->index();
            }
        }

        public function userLogin(){
        
            $errors = [];
            $errors['errorType'] = 'loginErrors';
        
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                
                $data = [
                    'email' => $_POST['emailForLogin'],
                    'password' => $_POST['passwordForLogin']
                ];

                $user = new UserModel;

                $result = $user->first(['email' => $data['email']]);
                if($result){
                    if (password_verify($data['password'], $result->password)){
                        $_SESSION['user_id'] = $result->user_id;
                        header("Location: " . ROOT . "/RegisteredUserHome");
                        exit;
                    }
                    else{
                        $errors["password_error"] = "Invalid password!";
                        $this->view('unregisteredUserHome', ['errors' => $errors]);
                    }
                    
                }
                else{
                    $errors['user_error'] = "There is no user exists with such email";
                    $this->view('unregisteredUserHome', ['errors' => $errors]);
                }
            }
            else{
                $this->index();
            }
        }

        public function logout()
        {
            // Unset all session variables
            $_SESSION = [];

            // Destroy the session
            session_destroy();

            // Redirect to login page
            header("Location: " . ROOT . "/Home");
            exit();
        }
    }



    
    

    
    