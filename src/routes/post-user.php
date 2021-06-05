<?php

    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;


    /*
    post one user
    */
    $app->post('/post-user', function ($request, $response, array $args) {
        // Create new USER

        $format = 'Y-m-d H:i:s';

        $date = DateTime::createFromFormat($format, date('Y-m-d H:i:s'));

        $datestr=$date->format('Y-m-d H:i:s');

        $sql="INSERT INTO usuarios (name,short_name,email,status,creation_date,last_access_date,last_access_ip)
        VALUES ('luis', 'luisin', 'pp@gg.com', 'Activo','$datestr','$datestr',rand(0-255));";

     var_dump($sql);
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
    });


?>