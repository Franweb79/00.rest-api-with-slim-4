<?php
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    /**
    * Get users
    */
    // create GET HTTP request
    $app->get('/get-all-users', function( Request $request, Response $response){


        $sql = "SELECT * FROM usuarios";

        $responseJSONencoded=""; //on the try we will do with json_encode(), on the catch with a literal

        //we create a connection now, first the Connection object and incoke its connection method

        try{

            /*connect to DB. 
            We don´t need to make a require to the db-connection.php because this get-all-users.php file will be called (required) from the 
            index.php, where it is already required the file*/

            $dbConnObj=new Connection(); 

            $PDOconn=$dbConnObj->connect();/*because to use the query method must be a PDO object, and we do that
            on the connect method*/
            //query

            $stmt = $PDOconn->query( $sql );
            $users = $stmt->fetchAll( PDO::FETCH_OBJ );
            $dbConnObj = null; // clear db object (close the connection)

            // print out the result as json format
            $responseJSONencoded=json_encode( $users );

            $response->getBody()->write($responseJSONencoded);

            return $response;




        }catch(PDOException $ex){

            $responseJSONencoded='{"error": "message":'. $ex->getMessage() . '}';
            $response->getBody()->write($responseJSONencoded);

            return $response;
        }
    });



?>