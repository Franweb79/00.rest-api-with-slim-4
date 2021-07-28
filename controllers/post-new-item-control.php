<?php

    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    use Psr\Http\Server\RequestHandlerInterface as RequestHandler; //for the middleware

    use Valitron\Validator as V;
    
    use Slim\Views\PhpRenderer;

    $postItemControlMiddleware=function(Request $request, RequestHandler $handler){

        

        $response = $handler->handle($request);
        
        if( (!isset($_SESSION['is_user_logged']) && !isset($_COOKIE['s-token'])) || isset($_GET)  ){

            
            

           // var_dump($_SESSION);
           
          // die();
        
            return $response->withHeader('Location', './');
        
        }else
        {
            return $response;
        }
    
    
    };

      /*
    
        we won´t allow accessing it through get, so we redirect to index.php 

        which should lead to routes-table-view.php

        //TODO maybe check all the same for the rest of routes, maybe can be done on widdleware adding a statement

        if (isset ($_GET))

        TO THE OTHER CONDITIONS

        I THINK IT IS NOT POSSIBLE CAUSE MIDDLEWARE WILL TRIGGER WHEN POST ( $app->post), 

        so we must set $app->get
        
    */

    $app->get('/post-new-item-control', function (Request $request, Response $response, $args){ 
        
        return $response->withHeader('Location', './');
        
    });

    $app->post('/post-new-item-control', function (Request $request, Response $response, $args){ 
        
        
        
    })->add($postItemControlMiddleware);


?>