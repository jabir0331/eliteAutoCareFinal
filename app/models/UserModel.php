<?php

    class UserModel{

        use Model;

        protected $table = 'users';

        protected $allowedColumns = [
            'user_id',
            'email',
            'password',
            'first_name',
            'last_name',
            'phone_number',
        ];

        public function checkExistingEmail($email)
        {
            $result = $this->where(['email' => $email]);
            return !empty($result);
        }

        public function validate($data){
            $errors = [];
        
            // Validate email
            if (empty($data['email'])) {
                $errors['email'] = "Email is required.";
            } 
            elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Email is not valid.";
            } 
            elseif ($this->checkExistingEmail($data['email'])) {
                $errors['email'] = "Email is already registered.";
            }
        
            // Validate password
            if (empty($data['password'])) {
                $errors['password'] = "Password is required.";
            } 
            elseif (strlen($data['password']) < 8) {
                $errors['password'] = "Password must be at least 8 characters long.";
            }
        
            // Validate confirm password
            if (empty($data['confirmPassword'])) {
                $errors['confirmPassword'] = "Confirm Password is required.";
            } 
            elseif ($data['password'] !== $data['confirmPassword']) {
                $errors['confirmPassword'] = "Password and Confirm Password do not match.";
            }
        
            return $errors;
        }

    }
    

