<?php


    //this are namespaces
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Selective\BasePath\BasePathMiddleware;
    use Psr\Http\Message\ResponseInterface;
    use Slim\Exception\HttpNotFoundException;
    use Slim\Factory\AppFactory;
    use Selective\BasePath\BasePathDetector;

    use Valitron\Validator as V;

    use Slim\Views\PhpRenderer;

     //TODO avoid user accesing register form when logged in, that maybe with a middleware
     //TODO think about if is neccesary making middlewares to be shown or not for the rest of routes or php files, and which requisites they should have each of them to access or not

    $app->get('/register', function ($request, $response, $args) {

        session_start();
        $renderer = new PhpRenderer('../templates');

        return $renderer->render($response, "register-form-view.php", $args);
    });



?>