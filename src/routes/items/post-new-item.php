<?php

    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    use Psr\Http\Server\RequestHandlerInterface as RequestHandler; //for the middleware

   


    use Slim\Views\PhpRenderer;


    $postItemControlMiddleware=function(Request $request, RequestHandler $handler){

        

        $response = $handler->handle($request);
        
        if( !isset($_SESSION['is_user_logged']) && !isset($_COOKIE['s-token']) ){

            
            

           // ($_SESSION);
           
          // die();
        
            return $response->withHeader('Location', './');
        
        }else
        {
            return $response;
        }
    
    
    };

  
    $app->get('/post-new-item', function( Request $request, Response $response, array $args){

        session_start();

        

        $renderer = new PhpRenderer('../templates');

        return $renderer->render($response, "post-new-item-view.php", $args); 

        //return $response;

        /*$_SESSION['message-to-display-on-alert']="This operation is not allowed ";
        return $response->withHeader('Location', './');*/


    })->add($postItemControlMiddleware);



  



?>