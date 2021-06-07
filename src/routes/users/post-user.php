<?php

    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;


    /*
    post one user
    */
    $app->post('/post-user', function ($request, $response, array $args) {
        // Create new USER

        //test if email is well formed https://www.w3schools.com/php/php_form_url_email.asp

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $nameCheck=test_input($_POST["name"]);
        $emailCheck= test_input($_POST["email"]);

        
        
        $statusValue=$_POST["status"];/*to operate with it without losing it, remember $_POST only has its value one time */
        /*if mail is ok, and status has allowed values*/
        if( ($statusValue=="Activo"||$statusValue=="Inactivo"||$statusValue=="activo"||$statusValue=="inactivo" ) && (filter_var($emailCheck, FILTER_VALIDATE_EMAIL)) && preg_match("/^[a-zA-Z-' ]*$/",$nameCheck)) {


            //  var_dump($_POST["name"]);

            $nameValue=$_POST["name"];
            $shortNameValue=$_POST["short_name"];
            $emailValue=$_POST["email"];
            //$statusValue=$_POST["status"];

           // var_dump($nameValue);
        
            $format = 'Y-m-d H:i:s';

            $date = DateTime::createFromFormat($format, date('Y-m-d H:i:s'));

            $datestr=$date->format('Y-m-d H:i:s');

            $ipdata1=rand(0,255);

            $ipdata2=rand(0,255);

            $ipdata3=rand(0,255);

            $ipdata4=rand(0,255);

            $allIpData=$ipdata1.".". $ipdata2.".". $ipdata3.".".$ipdata4;

            $sql="INSERT INTO usuarios (name,short_name,email,status,creation_date,last_access_date,last_access_ip)
            VALUES ('$nameValue', '$shortNameValue', '$emailValue', '$statusValue','$datestr','$datestr', '$allIpData');";

        
            $responseJSONencoded="";

            try{

                $dbConnObj=new Connection();

                $PDOconn=$dbConnObj->connect();

                //query

                $stmt = $PDOconn->query( $sql );

            

                $responseJSON_encoded="{'message': 'user succesfully added'}";

                $dbConnObj = null; // clear db object (close the connection)


                $response->getBody()->write($responseJSON_encoded);



                return $response->withHeader('Content-Type', 'application/json');


            }catch (PDOException $exc){

                $responseJSONencoded='{ "message": "'. $exc->getMessage() . '"}';
                $response->getBody()->write( $responseJSONencoded);

                return $response->withHeader('Content-Type', 'application/json');

            }

        }else
        {
            $responseJSONencoded='{ "message": " Status must be active or inactive, also check if email is well formed, and if name has only letters and white spaces"}';

            
            $response->getBody()->write( $responseJSONencoded);

            return $response->withHeader('Content-Type', 'application/json');

        }
         
    });


?>