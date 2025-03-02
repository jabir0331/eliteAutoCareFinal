<?php

class APP {
    private $controller = "Home"; // Default controller
    private $method = "index"; // Default method

    private function splitURL() {
        $URL = $_GET['url'] ?? 'home';
        $URL = explode("/", trim($URL, "/"));
        return $URL;
    }

    public function loadController() {
        $URL = $this->splitURL();
        $controllerPath = "../app/controllers/";

        // Check for nested paths (e.g., student/ControllerName)
        if (count($URL) > 1 && is_dir($controllerPath . ucfirst($URL[0]))) {
            $controllerPath .= ucfirst($URL[0]) . "/" . ucfirst($URL[1]) . ".php"; // e.g., app/controllers/student/StudentController1.php
            $controllerName = ucfirst($URL[1]);
            unset($URL[0], $URL[1]);
        } else {
            // Check for controllers directly in app/controllers (e.g., Signup.php)
            $controllerPath .= ucfirst($URL[0]) . ".php"; // e.g., app/controllers/Signup.php
            $controllerName = ucfirst($URL[0]);
            unset($URL[0]);
        }

        if (file_exists($controllerPath)) {
            require $controllerPath; // Include the controller file
            $this->controller = $controllerName;
        } else {
            // Load 404 controller if the specified controller does not exist
            require "../app/controllers/_404.php";
            $this->controller = "_404";
        }

        /* Instantiate the controller */
        $controller = new $this->controller();

        /* Select method */
        if (!empty($URL[2])) {
            if (method_exists($controller, $URL[2])) {
                $this->method = $URL[2]; // Set the method
                unset($URL[2]);
            } else {
                // If the method does not exist, use the 404 controller's default method
                $this->controller = "_404";
                $controller = new $this->controller(); // Reinstantiate 404 controller
                $this->method = "index"; // Default to index method in 404 controller
            }
        }else{
            if (!empty($URL[1])) {
                if (method_exists($controller, $URL[1])) {
                    $this->method = $URL[1]; // Set the method
                    unset($URL[1]);
                } else {
                    $this->controller = "_404";
                    $controller = new $this->controller(); // Reinstantiate 404 controller
                    $this->method = "index";
                }
            }
        }

        /* Remaining parts of the URL are parameters */
        $params = $URL ? array_values($URL) : [];

        /* Call the controller method with parameters */
        call_user_func_array([$controller, $this->method], $params);
    }
}