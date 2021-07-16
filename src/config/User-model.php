<?php

    //require 'db-connection-dev.php'; no needed, it will be called on the index.php

    /*TODO write correct comemnts of each method with @param and @return and so, like on java

    http://www.drjava.org/docs/user/ch10.html

    */


    class User{

        private $id_user;
        private $user_name;
        private $user_email;
        private $user_password;

        /*
        
            to check if user is on db or not

            @param $user_email provided by login form
            @param $user_password provided by login form

            @return a response which can be :- null if no users with such params returned
                                             - data of the user if exists
                                             - an error message if exception is thrown
        
        
        */

        public function userLogin($user_email,$user_password){

          

              $sql = "SELECT * from users where  (user_email = :usermail) AND (user_password = :userpass)"; 

              /*we hash the pass because password is hashed and mustr check*/
              
            try{

                $conObj=new Connection();

                $conn=$conObj->connect();



                $sth =$conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

                 /*execute is for prepared sentence*/
                 $sth->execute( array(':usermail' => $user_email, ':userpass' => $user_password) ) ;

              
                 /*fetchAll() gives us an array, we set as an associate array, and store it on a variable*/
               
                $users=$sth->fetchAll(PDO::FETCH_ASSOC);      
             

                if(count($users)>0 ){

                    $response= $users;

                }else{


                    $response=null;
                }

               
                $conObj = null; // clear db object (close the connection)

               
                

                
                return $response; /*maybe with this we store on a slim response later when execiuted, on login-control.php*/

               

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



        /*
        
            insert token on db when user is logged in

            @param $p_id_user is the user_id to compare with that field on the db

            @return -the token we have set.
                    -an error message if exception is thrown

        
        */
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


                 return $token;

            }catch(PDOException $ex){

                return "{'errormessage': . '$ex'}";

            }

        }

        /*
        
            will get the current session token.
            if it is !null, we compare $p_cookieToken and retrieved session_token from db
            and if it is the same,  we go to the / path with user logged in. 
            If not the same, also to / but no logged user, with an error message and showing login form

            @param $p_cookieToken the token we have stored on a cookie 

            @return a response with: -an error if something on session has been manipulated
                                     -the user with session token value which is the same of the cookie token value
                                     -an error message if exception is thrown

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

        /*
            will be used on register-control.php
            to insert user if all register form data is valid

            @param p_userData contains the valid user data we will insert


        */
        public function insertUser($p_userData){

        }
    }

?>