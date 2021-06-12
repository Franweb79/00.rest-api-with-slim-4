<?php
    
    //this are namespaces
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Selective\BasePath\BasePathMiddleware;
    use Psr\Http\Message\ResponseInterface;
    use Slim\Exception\HttpNotFoundException;
    use Slim\Factory\AppFactory;
    use Selective\BasePath\BasePathDetector;

    //include the SLIM framework

    require_once __DIR__ . '/../vendor/autoload.php';

     // include DB connection file (at the moment dev one, later production one when finished, on my own host)
    require '../src/config/db-connection-dev.php';

    //create SLIM instance, on slim 4 is so:

    $app = AppFactory::create();

    // # include users route, must do AFTER the declaration of app instance, dont know why. I GUESS BECAUSE THE $app invoked 
    //on those routes still not exists until $app is created
    require '../src/routes/users/get-all-users.php';
    require '../src/routes/users/get-user.php';
    require '../src/routes/users/post-user.php';

    //ITEMS ROUTES

    require '../src/routes/items/get-all-items.php';

    //log in route

    require '../src/routes/login.php';



    // Add Slim routing middleware
    $app->addRoutingMiddleware();

    /*deleted this from the official example
    
    $app->add(new BasePathMiddleware($app));
    
    */

    /*and added this*/
    $app->setBasePath("/00.rest-api-with-slim-4/public");
    $app->addErrorMiddleware(true, true, true);


  

    // Define app routes
    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write("Hello, world!");
        return $response;
    });

   /* $app->get('/users', function ($request, $response, array $args) {

        $response->getBody()->write("path to get users");
        return $response;
        
    });*/

 


   
    

    // Run app
    $app->run();

?>