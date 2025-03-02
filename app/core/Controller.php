<?php

    class Controller{

        public function loadModel($model)
	    {
		    $modelPath = "../app/models/" . $model . ".php";

		    if (file_exists($modelPath)) {
			    require_once $modelPath;

			// Return an instance of the model class
			return new $model();
		    } 
            else {
			    die("The model file {$modelPath} does not exist.");
		    }
	    }
        public function view($name, $data = []) {
            if (!empty($data)) {
                if (is_object($data)) {
                    $data = (array) $data; // Convert object to array
                }
                if (is_array($data)) {
                    extract($data);
                } else {
                    throw new Exception("Data must be an array or an object that can be converted to an array.");
                }
            }
            $fileName = "../app/views/" . $name . ".view.php";
        
            if (file_exists($fileName)) {
                require $fileName;
            } else {
                $fileName = "../app/views/404.view.php";
                require $fileName;
            }
        }        
    }
    