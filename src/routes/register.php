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

    $app->get('/register', function ($request, $response, $args) {

        echo "hi";
        $renderer = new PhpRenderer('../templates');

        return $renderer->render($response, "register-form-view.php", $args);
    })



?>