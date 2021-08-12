<?php
    //this are namespaces
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;

    use Slim\Views\PhpRenderer;

    $app->post('/close-session-control', function (Request $request, Response $response, $args){

        session_start();

        $data=$request->getParsedBody();


        if(  (isset($data["close-session-input-name"])) && ($data["close-session-input-name"]=="yes")     ){

            if(   isset($_COOKIE['s-token'])   ){

              

               ($_COOKIE['s-token']);

               

                setcookie('s-token','', time() - 3600);

                ($_COOKIE['s-token']);

                

                unset($_COOKIE['s-token']);
            }
         
            

            $_SESSION['message-to-display-on-alert']="Closed session";

           
            

            

            return $response->withHeader('Location', './');
        }

        $jsondata=json_encode($data);

        $response->getBody()->write($jsondata);


        return $response; 
    } );

    /*

        to control if user reloads the page or try to access through URL without permission,
        we control also the get route

    */


    $app->get('/close-session-control', function (Request $request, Response $response, $args){

       


        return $response->withHeader('Location', './');
    });

?>

