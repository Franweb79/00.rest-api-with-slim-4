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

    //create SLIM instance, on slim 4 is so:

    $app = AppFactory::create();



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

    //test dymanic names ans so, still not with database
    $app->get('/users/{name}', function ($request, $response, array $args) {

        //capture the name
        
        $userName = $request->getAttribute('name');

        $response->getBody()->write("hi there ".$userName);
        return $response;
        
    });


    

    // Run app
    $app->run();

?>