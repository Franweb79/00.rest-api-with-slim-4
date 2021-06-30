<?php

    //require 'db-connection-dev.php'; no needed, it will be called on the index.php


    class User{

        private $id_user;
        private $user_name;
        private $user_email;
        private $user_password;

        /*to check if user is on db or not*/

        public function userLogin($user_email,$user_password){

          

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

             

                /*if the resulting array is not empty, we attach to the response; if not, response is null*/
                if(count($users)>0 ){

                    $response= $users;

                }else{

                   // $response ='{"message" : "no users with this mail, or pass on our database"}';

                    $response=null;
                }

               
                $conObj = null; // clear db object (close the connection)

               
                

                
                return $response; /*mnaybe with this we store on a slim response later when execiuted, on login-control.php*/

            

               
                //var_dump("done");
               

            }catch(PDOException $ex){

                return "{'errormessage': . '$ex'}";

            }

        }

        public function createToken(){

            //Generate a random string.
            $token = openssl_random_pseudo_bytes(16);

            //Convert the binary data into hexadecimal representation.
            $token = bin2hex($token);

            //Print it out for example purposes.
            return $token;

        }



        /*insert token when user is logged in*/
        public function setToken($p_id_user){

            $token=$this->createToken();

            //is an update because value at the beginning is null
            //$sql="INSERT into users (session_token) VALUES (:p_token) where  (id_user = :p_id_user)";
            $sql="UPDATE users 
                SET session_token = :p_token
                WHERE (id_user = :p_id_user)
                ";

            try{

                $conObj=new Connection();

                $conn=$conObj->connect();

                $sth =$conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

                 /*execute is for prepared sentence*/
                 $sth->execute( array(':p_token' => $token, ':p_id_user' => $p_id_user) ) ;

                 $conObj = null; // clear db object (close the connection)

                 //var_dump("e token dentro de set token es". $token);

                 return $token;

            }catch(PDOException $ex){

                return "{'errormessage': . '$ex'}";

            }

        }

        /*will get the current session token, if it is !null, we compare $p_cookieToken and retrieved session_token from db
         and 
         
         if it is the same, 
         
         we go to the / path logged. 
         
         If not the same, also to / we destrying session, an error message and show login form

        */
        public function checkUserSessionWithCookieToken($p_cookieToken){

            $sql="SELECT * FROM users where (:p_cookie_token = session_token)";

            try{

                $conObj=new Connection();

                $conn=$conObj->connect();

                $sth =$conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

                 /*execute is for prepared sentence*/
                 $sth->execute( array(':p_cookie_token' => $p_cookieToken) ) ;

                 $users=$sth->fetchAll(PDO::FETCH_ASSOC);

                 /* if the resulting array is not empty, we attach to the response; if not, response is null; if not, a gven message on json string literal format*/
                if(count($users)>0 ){

                    $response= $users;

                }else{

                   $response ='{"message" : "mmm I think that is not possible :/. Your session is wrong"}';

                   // $response=null;
                }



                 $conObj = null; // clear db object (close the connection)

                 //var_dump("e token dentro de set token es". $token);

                 return $response;

            }catch(PDOException $ex){

                return "{'errormessage': . '$ex'}";

            }

        }
    }

?>