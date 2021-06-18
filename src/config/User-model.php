<?php

    //require 'db-connection-dev.php'; no needed, it will be called on the index.php


    class User{

        private $id_user;
        private $user_name;
        private $user_email;
        private $user_password;

        /*to check if user is on db or not*/

        /* TODO must set password with hash*/
        public function userLogin($user_email,$user_password){

           /*$sql = "SELECT * from users where  (user_email = '".$user_email."') AND (user_password = '".$user_password."')"; /* TODO this but with prepared statements (look get-user.php), and using the data the login-control.php 

              $data = $request->getParsedBody(); provides us , well have to create two parameteres maybe for the user login to look for email and pass*/


              $sql = "SELECT * from users where  (user_email = :usermail) AND (user_password = :userpass)"; 

              /*we hash the pass because password is hashed and mustr check*/
              
            try{

                $conObj=new Connection();

                $conn=$conObj->connect();



                $sth =$conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

                 /*execute is for prepared sentence*/
                 $sth->execute( array(':usermail' => $user_email, ':userpass' => $user_password) ) ;

              
                 /*fetchAll() dives us an array, we set as an associate array, and store it on a variable*/
               
                $users=$sth->fetchAll(PDO::FETCH_ASSOC);

               //var_dump($users);

               // var_dump($user_email ."". $user_password);

                //var_dump($users);

             

                /*if the resulting array is not empty, we converty to json; if not, a guven message on json string literal format*/
                if(count($users)>0 ){

                    $response= $users;

                }else{

                   // $response ='{"message" : "no users with this mail, or pass on our database"}';

                    $response=null;
                }

               
                $conObj = null; // clear db object (close the connection)

                /*
                
                we convert result into JSON because that way it is a string, and then we can use it
                as argument on the write() method, since it needs a string
                
                also to be able to return data as json with the method $response->withHeader()
                
                */
                

                //var_dump($response);
           
                //var_dump("ey".$responseJSON_encoded);
                return $response; /*mnaybe with this we store on a slim response later when execiuted, on login-control.php*/

            

               
                //var_dump("done");
               

            }catch(PDOException $ex){

                return "{'errormessage': . '$ex'}";

            }

        }
    }

?>