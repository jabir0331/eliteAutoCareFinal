<?php

    /**
     * Main model trait for the application.
     */

     Trait Model{

        use Database;

        protected $limit = 10;
        protected $offset = 0;
        protected $order_type = "asc";
        protected $order_column = "id";
        

        public function selectALL(){
            $query = "SELECT * FROM $this->table";

            // $query = "SELECT * FROM $this->table ORDER BY $this->order_column $this->order_type LIMIT $this->limit OFFSET $this->offset";

            return $this->query($query);

        }

        // public function where($data, $data_not = []){

        //     $keys = array_keys($data);
        //     $keys_not = array_keys($data_not);

        //     $query = "SELECT * FROM $this->table WHERE ";
            

        //     foreach($keys as $key){
        //         $query .= $key . " = :" . $key . " && ";
        //     }

        //     foreach($keys_not as $key){
        //         $query .= $key . " != :" . $key . " && ";
        //     }

            // $query = trim($query, " && ");

            //$query .= " limit $this->limit offset $this->offset";
            

        //     $data = array_merge($data, $data_not);

        //     return $this->query($query, $data);
       
        // }


        //Up to now finely working where function. Jabir is commented this because this is not capable of handling >=, =< operators

        // public function where($data, $data_not = []) {
        //     $conditions = [];
        //     $params = [];
            
            // Handle regular conditions
            // foreach ($data as $key => $value) {
            //     if (strpos($key, '!=') !== false) {
                    // Handle not equal condition
                //     $actualKey = str_replace('!=', '', $key);
                //     $paramKey = str_replace(['!', '=', ' '], '', $key);
                //     $conditions[] = "$actualKey != :$paramKey";
                // } else {
                    // Handle equal condition
        //             $conditions[] = "$key = :$key";
        //         }
        //         $params[':' . str_replace(['!', '=', ' '], '', $key)] = $value;
        //     }
    
        //     $query = "SELECT * FROM $this->table";
        //     if (!empty($conditions)) {
        //         $query .= " WHERE " . implode(" AND ", $conditions);
        //     }
    
        //     return $this->query($query, $params);
        // }


        //The new where function by Jabir
        public function where($data, $options = []) {
            $conditions = [];
            $params = [];
            
            foreach ($data as $key => $value) {
                // Check if the key contains an operator
                if (preg_match('/(>=|<=|>|<|!=)/', $key, $matches)) {
                    $operator = $matches[0];
                    $cleanKey = str_replace($operator, '', $key);
                    $paramKey = str_replace(['>', '<', '=', ' '], '', $key);
                    $conditions[] = "$cleanKey $operator :$paramKey";
                } else {
                    // Regular equality condition
                    $conditions[] = "$key = :$key";
                    $paramKey = $key;
                }
                $params[':' . str_replace(['>', '<', '=', ' '], '', $paramKey)] = $value;
            }
    
            $query = "SELECT * FROM $this->table";
            if (!empty($conditions)) {
                $query .= " WHERE " . implode(" AND ", $conditions);
            }
    
            // Only add ordering if specifically requested in options
            if (!empty($options['order_by'])) {
                $order_column = $options['order_by'];
                $order_type = $options['order_type'] ?? 'ASC';  // Default to ASC if not specified
                $query .= " ORDER BY " . $order_column . " " . $order_type;
            }
        
            // Only add limit if specifically requested in options
            if (!empty($options['limit'])) {
                $query .= " LIMIT " . (int)$options['limit'];
            
                // Only add offset if limit is present and offset is specified
                if (!empty($options['offset'])) {
                    $query .= " OFFSET " . (int)$options['offset'];
                }
            }
    
            return $this->query($query, $params);
        }

       

        public function first($data, $data_not = []){

            $keys = array_keys($data);
            $keys_not = array_keys($data_not);

            $query = "SELECT * FROM $this->table WHERE ";

            foreach($keys as $key){
                $query .= $key . " = :" . $key . " && ";
            }

            foreach($keys_not as $key){
                $query .= $key . " != :" . $key . " && ";
            }

            $query = trim($query, " && ");

            $query .= " limit $this->limit offset $this->offset";

            $data = array_merge($data, $data_not);

            $result = $this->query($query, $data);

            if($result)
                return $result[0];
            
            return false;

        }

        public function insert($data){

            /**Remove unwanted data **/
            if(!empty($this->allowedColumns)){
        
                foreach($data as $key => $value){
        
                    if(!in_array($key, $this->allowedColumns)){
        
                        unset($data[$key]);
                    }
                }
            }
        
            $keys = array_keys($data);
            
        
            $query = "INSERT INTO $this->table(".implode(", ", $keys).") VALUES(:".implode(", :", $keys).")";
            
        
            // if($this->query($query, $data)){
            //     return true;
            // }
            
            // return false;
            try {
                $result = $this->query($query, $data);
                
                // Check if query was successful
                if ($result !== false) {
                    // return true;
                    return $this->lastInsertId(); // Return the last insert ID instead of true
                } else {
                    
                    // Log detailed error information
                    error_log('Insert query failed. Query: ' . $query);
                    error_log('Data: ' . print_r($data, true));
                    return false;
                }
            } catch (Exception $e) {
                // Log any database exceptions
                error_log('Database exception during insert: ' . $e->getMessage());
                return false;
            }
            
        }

        public function update($id, $data, $id_column = 'id'){

            if(!empty($this->allowedColumns)){

                foreach($data as $key => $value){

                    if(!in_array($key, $this->allowedColumns)){

                        unset($data[$key]);
                    }
                }
            }
            
            
            $keys = array_keys($data);
            $query = "UPDATE $this->table SET ";

            foreach($keys as $key){
                $query .= $key . " = :" . $key . ", ";
            }

            $query = trim($query, ", ");

            $query .= " WHERE $id_column = :$id_column";

            $data[$id_column] = $id;
            
            // return $this->query($query, $data);
            try {
                $result = $this->query($query, $data);
                if ($result !== false) {
                    return true;
                } else {
                    error_log('Update query failed. Query: ' . $query);
                    error_log('Data: ' . print_r($data, true));
                    return false;
                }
            } catch (Exception $e) {
                error_log('Database exception during update: ' . $e->getMessage());
                return false;
            }
            
        }

        public function delete($id, $id_column = 'id'){

            $data[$id_column] = $id;
            
            $query = "DELETE FROM $this->table WHERE $id_column = :$id_column";

            // if($this->query($query, $data)){
            //     return true;
            // }

            // return false;
            /*  Commented the above because, it is returning false even though 
                the query successfully exceuted*/
            try {
                $result = $this->query($query, $data);
                if ($result !== false) {
                    return true;
                } else {
                    error_log('Update query failed. Query: ' . $query);
                    error_log('Data: ' . print_r($data, true));
                    return false;
                }
            } catch (Exception $e) {
                error_log('Database exception during update: ' . $e->getMessage());
                return false;
            }
            
        }

     }
