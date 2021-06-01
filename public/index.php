<?php
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Selective\BasePath\BasePathMiddleware;
    use Psr\Http\Message\ResponseInterface;
    use Slim\Exception\HttpNotFoundException;
    use Slim\Factory\AppFactory;
    use Selective\BasePath\BasePathDetector;

    require_once __DIR__ . '/../vendor/autoload.php';



    $app = AppFactory::create();



    // Add Slim routing middleware
    $app->addRoutingMiddleware();

    /*deleted this from the official example
    
    $app->add(new BasePathMiddleware($app));
    
    */

    /*and added this*/
    $app->setBasePath("/00.rest-slim-test/public");
    $app->addErrorMiddleware(true, true, true);

    // Define app routes
    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write("Hello, world!");
        return $response;
    });

    // Run app
    $app->run();

?>