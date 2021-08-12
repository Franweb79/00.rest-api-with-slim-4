<?php

    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    use Psr\Http\Server\RequestHandlerInterface as RequestHandler; //for the middleware

   
    /*

        in this case, middleware must redirect also if no post form is coming from routes_table_view, 
        not only if no user is logged

    */

    $getItemControlMiddleware=function(Request $request, RequestHandler $handler){

        

        $response = $handler->handle($request);
        
        if(  ( !isset($_SESSION['is_user_logged']) && !isset($_COOKIE['s-token']) )  || (  !isset($_GET['get-item-field-name']) )  ){

            
            

           // ($_SESSION);
           
          // die();
        
            return $response->withHeader('Location', './');
        
        }else
        {
            return $response;
        }
    
    
    };


      /**
       * 
       * with no param coming from a form, we dont admit request and return to index  through middleware
       * the way to put optional segments is between brackets
       * we had here the ãrgs array cause there are parameters stored
       * 
       *
      */
   
      $app->get('/get-item[/{param}]', function( Request $request, Response $response, array $args){

        /*

             we need to make the middleware work correctly, in order to recover the session and check 
             what must be checked on the middleware with $_SESSION and so

        */

        session_start();

      

        //($args);
       
        //get-item

        $sql="SELECT * from items where (id_item=:get_item_form_field) OR (item_name=:get_item_form_field) ";

        $responseJSONencoded=""; //on the try we will do with json_encode(), on the catch with a literal

        try{

            $conObj=new Connection();

            $conn=$conObj->connect();



            $sth =$conn->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));


            /*execute is for prepared sentence*/
            $sth->execute( array(':get_item_form_field' => $_GET['get-item-field-name']) ) ;

             /*fetchAll() gives us an array, we set as an associate array, and store it on a variable*/
               
             $items=$sth->fetchAll(PDO::FETCH_ASSOC); 
             
             if(count($items)>0 ){

               //wil caall it "$res" to avoid problems with the PSR-7 "$response" slim returns
                $res= $items;

            }else{


                $res=array("error" => "No items with this ID  or Name" );
            }

           
            $conObj = null; // clear db object (close the connection)

           
             /*
            
                we convert result into JSON because that way it is a string, and then we can use it
                as argument on the write() method, since it needs a string
                
                also to be able to return data as json with the method $response->withHeader()
            
            */
            $responseJSONencoded=json_encode( $res );

           

            /* 
            
                return $response must return a response object; if we wanrt to return as a json object to make it
                more easy to use by clients, then pass the json created with json_encode to the body of the response
                through getBody()->write(), and then set proper header with the "response->withHeader() method, as said before
            
            */

            $response->getBody()->write($responseJSONencoded);

            
            

           // ("ee");

           // die();

        }catch(PDOException $ex){

            $responseJSONencoded=json_encode( array ("exception"=> $ex->getMessage()) );
            $response->getBody()->write( $responseJSONencoded);

           
        }

        return $response->withHeader('Content-Type', 'application/json');

    })->add($getItemControlMiddleware);

    /*$app->get('/get-item', function( Request $request, Response $response){

        

        return $response->withHeader('Location', './');



    })*/

   
?>
