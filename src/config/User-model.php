<?php

    //require 'db-connection-dev.php'; no needed, it will be called on the index.php


    class User{

        private $id_user;
        private $user_name;
        private $user_email;
        private $user_password;

        /*to check if user is on db or not*/
        public function userLogin(){

            $sql = "SELECT * from users"; /* TODO this but with prepared statements (look get-user.php), and using the data the login-control.php 

              $data = $request->getParsedBody(); provides us , well have to create two parameteres maybe for the user login to look for email and pass*/


            try{

                $conObj=new Connection();

                $conn=$conObj->connect();

                $stmt = $conn->query( $sql );
                $users = $stmt->fetchAll( PDO::FETCH_OBJ );
                $conObj = null; // clear db object (close the connection)

            /*
            
            we convert result into JSON because that way it is a string, and then we can use it
            as argument on the write() method, since it needs a string
            
            also to be able to return data as json with the method $response->withHeader()
            
            */
            $responseJSON_encoded=json_encode( $users );

           
            var_dump($responseJSON_encoded);
            return $responseJSON_encoded;

            

               
                //var_dump("done");
               

            }catch(PDOException $ex){

                return "{'errormessage': . '$ex'}";

            }

        }
    }

?>