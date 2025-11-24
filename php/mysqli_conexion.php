<?php

    class MysqliConexion extends Conexion{

       private static $db_host="localhost";
        private static $db_name;
        private static $db_user="root";
        private static $db_password="";
        private $con;
        
        
        public function conectar():mysqli{

            $this->con = new mysqli($this::$db_host,$this::$db_user,$this::$db_password,$this::$db_name);
            
        
            if($this->con->connect_errno){
                die('Error de conexion' . $this->con->connect_errno );
            }


            return $this->con;
        }   


        public function closeConexion():void{
            $this->con->close();
        }



        public function exectuteQuery(String $query){
          $conn=  $this->conectar();

          $conn->query($query);

          $this->closeConexion();


        }

        public function reedQuery(String $sql, array $params =[] ):array{

            $statement= $this->con->conectar()->prepare($sql);

            if($statement=== false){
                throw new Exception("Error al preparar la consulta: ");
            }
            
            $statement->exectute();

            $query_result= $statement->get_result();

            if($query_result){

                while($row = $query_result->fetch_assoc()){
                    $results[]= $row;
                }

                    $query_result->free();
            
            }

            $statement->closeConexion();

            return $results;
        }

    }


    

?>