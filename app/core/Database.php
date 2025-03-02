<?php

Trait Database{

    private $connection = null;         /*New changes by Jabir */

    private function connect(){
        /*Old method*/
        // $string = "mysql:hostname=".DBHOST.";dbname=".DBNAME;
        // $con = new PDO($string, DBUSER, DBPASS);
        //$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); This was already commented
        // return $con;

        /*New method by Jabir */
        if ($this->connection === null) {
            $string = "mysql:hostname=".DBHOST.";dbname=".DBNAME;
            $this->connection = new PDO($string, DBUSER, DBPASS);
        }
        return $this->connection;

    }

    /**This function is used to get the first value from a result set */
    public function get_row($query, $data = []){

        $con = $this->connect();
        $stm = $con->prepare($query);

        $check = $stm->execute($data);

        if($check){

            $result = $stm->fetchALL(PDO::FETCH_OBJ);
            if(is_array($result) && count($result)){

                return $result[0];
            }
        }

        return false;
    }

     /**This function is used to get all values from a result set */
    public function query($query, $data = []){

        $con = $this->connect();
        $stm = $con->prepare($query);
        $check = $stm->execute($data);
        

        if($check){
            
            $result = $stm->fetchALL(PDO::FETCH_OBJ);
            if(is_array($result) && count($result)){
                return $result;
            }
            return [];
        }
        return false;
    }

     //This function is used to get the last inserted id
    public function lastInsertId() {
        return $this->connect()->lastInsertId();
    }

}


    