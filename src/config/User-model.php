<?php

    //require 'db-connection-dev.php'; no needed, it will be called on the index.php

    /*
    
        I will write correct comments on many methods with @param and @return and so, like on java

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

                 /* if the resulting array is not empty, we attach to the response; if not, a gven message on json string literal format*/
                if(count($users)>0 ){

                    $response= $users;

                }else{

                   
                   $response ='{"message" : "mmm I think that is not possible :/. Your session is wrong"}';

                }



                 $conObj = null; // clear db object (close the connection)

                 

                 return $response;

            }catch(PDOException $ex){

                return "{'errormessage': . '$ex'}";

            }

        }

        /*
            will be used on register-control.php
            to insert user if all register form data is valid.
            The redirection when user is succesfully registered or not must be done later on register.control-php, because
            a method should do only what it says it does (inserting an user)

            @param p_registerFormData is an array which contains the valid user data we will insert.
                    WARNING: the password field will be hashed before inserting


        */
        public function insertUser($p_registerFormData){


           $sql="INSERT INTO users (user_name, user_email, user_password, session_token)
            VALUES (:p_user_name, :p_user_email, :p_user_password, NULL);";

            try{

                
                
                $p_passToBeHashed=$this->hashPassword($p_registerFormData["password"]);

               


                $conObj=new Connection();

                $conn=$conObj->connect();

                $sth =$conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

                 /*execute is for prepared sentence*/
                $sth->execute( array(':p_user_name' => $p_registerFormData["name"],
                               ':p_user_email' => $p_registerFormData["email"],
                               ':p_user_password' => $p_passToBeHashed )

                
                
                             ) ;


                $conObj = null; // clear db object (close the connection)

            }catch(PDOException $ex){

                return "{'errormessage': . '$ex'}";

            }

        }

        /*
            will hash the password before inserting it on database, on the insertUser method

            @param $p_passToBeHashed 
            @return -the hashed password
                    - an exception is something went wrong. In this case is an exception type, 
                    not a PDOException type like when we work with PDO statements


        */

        public function hashPassword($p_passToBeHashed){

            try{

                $hashedPass=md5($p_passToBeHashed);

                return $hashedPass;

            }catch(exception $ex){

                return "{'errormessage': . '$ex'}";

            }



        }

        /*

            on register-control
            .php, this will check if email given as parameter exists on database. So, if user with such mail exists

            @param the new user email we are trying to register

            @return NULL or not
            
        */
        public function checkIfEmailExists($p_user_to_register_email){

            $sql="SELECT user_email from users where (user_email = :user_email)";


            try{


                $conObj=new Connection();

                $conn=$conObj->connect();

                $sth =$conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

                 /*execute is for prepared sentence*/
                 $sth->execute( array(':user_email' => $p_user_to_register_email) ) ;

                 $users=$sth->fetchAll(PDO::FETCH_ASSOC);

                

                 /* 
                 
                    if the resulting array is not empty, we attach to the response; if not, response is null
                 
                 */
                if(count($users)>0 ){

                    $response= $users;

                }else{

                   $response = NULL;

                   
                }

                $conObj = null; // clear db object (close the connection)

                return $response;


            }catch(PDOException $ex)
            {
                return "{'errormessage': . '$ex'}";
            }
        }
    }

?>