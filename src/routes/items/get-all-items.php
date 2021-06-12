<?php
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    /**
    * Get users
    */
    // create GET HTTP request
    $app->get('/get-all-items', function( Request $request, Response $response){


        $sql = "SELECT * FROM items";

        $responseJSONencoded=""; //on the try we will do with json_encode(), on the catch with a literal

        //we create a connection now, first the Connection object and incoke its connection method

        try{

            /*connect to DB. 
            We don´t need to make a require to the db-connection.php because this get-all-users.php file will be called (required) from the 
            index.php, where it is already required the file*/

            $dbConnObj=new Connection(); 

            /*because to use the query method must be a PDO object, and we do that
            on the connect() method*/

            $PDOconn=$dbConnObj->connect();
            //query

            $stmt = $PDOconn->query( $sql );
            $users = $stmt->fetchAll( PDO::FETCH_OBJ );
            $dbConnObj = null; // clear db object (close the connection)

            /*
            
            we convert result into JSON because that way it is a string, and then we can use it
            as argument on the write() method, since it needs a string
            
            also to be able to return data as json with the method $response->withHeader()
            
            */
            $responseJSON_encoded=json_encode( $users );

           

            /* 
            
            return $response must return a response object; if we wanrt to return as a json object to make it
            more easy to use by clients, then pass the json created with json_encode to the body of the response
            through getBody()->write(), and then set proper header with the "response->withHeader() method, as said before
            
            */

            $response->getBody()->write($responseJSON_encoded);

            




        }catch(PDOException $ex){

            $responseJSONencoded='{"error": "message":'. $ex->getMessage() . '}';
            $response->getBody()->write( $responseJSONencoded);

           
        }

        return $response->withHeader('Content-Type', 'application/json');
    });
