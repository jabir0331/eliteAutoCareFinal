<?php

    define('APP', 'http://localhost/gitEliteAutoCare/eliteAutoCareFinal/app');
    define('ROOT', 'http://localhost/gitEliteAutoCare/eliteAutoCareFinal/public');
    define('CSS', 'http://localhost/gitEliteAutoCare/eliteAutoCareFinal/public/assets/css');
    define('IMAGES', 'http://localhost/gitEliteAutoCare/eliteAutoCareFinal/public/assets/images');
    define('JS', 'http://localhost/gitEliteAutoCare/eliteAutoCareFinal/public/assets/js');
    define('UPLOADS', 'http://localhost/gitEliteAutoCare/eliteAutoCareFinal/public/uploads');
    define('APPROOT',dirname(dirname(__FILE__)));


    if($_SERVER['SERVER_NAME'] == 'localhost'){

        /** database config **/
        define('DBHOST', 'localhost');
        define('DBNAME', 'elite_auto_care');
        define('DBUSER', 'root');
        define('DBPASS', '');
    }
    else{
        define('ROOT', 'https://www.eliteautocare.lk');
    }
    
    
    