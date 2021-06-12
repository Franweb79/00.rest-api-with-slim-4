<?php

    //this are namespaces
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Selective\BasePath\BasePathMiddleware;
    use Psr\Http\Message\ResponseInterface;
    use Slim\Exception\HttpNotFoundException;
    use Slim\Factory\AppFactory;
    use Selective\BasePath\BasePathDetector;

    use Slim\Views\PhpRenderer;

    $app->get('/login', function ($request, $response, $args) {
        $renderer = new PhpRenderer('../templates');/*dont know if from the index or from the routes/login.php*/

        return $renderer->render($response, "login-form-view.php", $args);
    })->setName('login');

?>