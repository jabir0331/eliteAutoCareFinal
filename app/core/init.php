<?php
    // spl_autoload_register(function($classname){
    //     require $filename = "../app/models/".ucfirst($classname).".php";
    // });
    // require 'config.php';
    // require 'functions.php';
    // require 'Database.php';
    // require 'Model.php';
    // require 'Controller.php';
    // require 'App.php';

    spl_autoload_register(function($classname){
        $filename = "../app/models/".ucfirst($classname).".php";
        if(file_exists($filename)){
            require $filename;
        }
    });
    
    require 'config.php';
    require 'functions.php';
    require 'Database.php';
    require 'Model.php';
    require 'Controller.php';
    require 'App.php';