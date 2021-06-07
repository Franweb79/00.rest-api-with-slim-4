<?php

    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;


    /*GET USER BY nAME*/

       //test dymanic names and so, still not with database
       $app->get('/users/{name}', function ($request, $response, array $args) {

        

        $responseJSONencoded="";

        try{

           //capture the name
        
            $userName = $request->getAttribute('name');
            
            
            $sql="SELECT * FROM usuarios where name = :name";

            /*invoke custom class Connection*/

            $connObj=new Connection();

            /*inside that class, we can use the connect method to create a PDO connection with user and pass given*/

            $PDOconn=$connObj->connect();

            /* https://www.php.net/manual/es/pdo.prepare.php*/

            $sth =   $PDOconn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

           /*execute is for prepared sentence*/
            $sth->execute( array(':name' => $userName) );

           /*fetchAll() dives us an array, we set as an associate array, and store it on a variable*/

            $result=$sth->fetchAll(PDO::FETCH_ASSOC);

            /*if the resulting array is not empty, we converty to json; if not, a guven message on json string literal format*/
            if(count($result)>0 ){

                $responseJSONencoded= json_encode($result);

            }else{

                $responseJSONencoded='{"message" : "no users with this name on our database"}';
            }

            


            /*we write the result as json on the body of thew response before showing it*/
            $response->getBody()->write( $responseJSONencoded);

            $dbConnObj = null; // clear db object (close the connection)



        }catch(PDOException $exc){

            $responseJSONencoded='{ "message": "'. $exc->getMessage() . '"}';
            $response->getBody()->write( $responseJSONencoded);

        }

       /*important to send as json also this header*/
        return $response->withHeader('Content-Type', 'application/json');
        



        
        
    });



?>