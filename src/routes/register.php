<?php


    //this are namespaces
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Selective\BasePath\BasePathMiddleware;
    use Psr\Http\Message\ResponseInterface;
    use Slim\Exception\HttpNotFoundException;
    use Slim\Factory\AppFactory;
    use Selective\BasePath\BasePathDetector;

    use Psr\Http\Server\RequestHandlerInterface as RequestHandler; //for the middleware


    use Valitron\Validator as V;

    use Slim\Views\PhpRenderer;

    

     /*

        this middleware will control if user is loggedin or not. In case is logged in, can´t access
        and return to ./
    
    */
     $userRegisterControlMiddleware=function(Request $request, RequestHandler $handler){

        $response = $handler->handle($request);

        if(  isset($_SESSION['is_user_logged']) || isset($_COOKIE['s-token'])  ){

        
            return $response->withHeader('Location', './');


        }else{
            return $response;
        }

     };

    $app->get('/register', function ($request, $response, $args) {

        session_start();//needed for the middleware
        $renderer = new PhpRenderer('../templates');

        return $renderer->render($response, "register-form-view.php", $args);
    })->add($userRegisterControlMiddleware);

    /*
        we create also the post to control it, 
        we return to main cause we can only access 
            -through the link on login page
            -through the search bar

        always when not logged of course, so we willadd the middleware here too

    */

    $app->post('/register', function ($request, $response, $args) {

        session_start();//needed for thew middleware
       

        return $response->withHeader('Location', './');

    })->add($userRegisterControlMiddleware);




?>