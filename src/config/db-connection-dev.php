<?php

    /**
     * Connect MySQL with PDO class
     * development version with no proper user and root
     */

     class Connection{
         private $host="localhost";
         private $user="root";
         private $pass="";
         private $databasename="database-for-slim-4-rest-api";

         /*no constructor for now*/

        public function connect(){

             // https://www.php.net/manual/en/pdo.connections.php
            $prepare_conn_str = "mysql:host=$this->host;dbname=$this->databasename";

            $conn = new PDO( $prepare_conn_str, $this->user, $this->pass );

            // https://www.php.net/manual/en/pdo.setattribute.php
            $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

            //var_dump($conn);

            // return databaseconnection back
           return $conn;
        }


     }


?>