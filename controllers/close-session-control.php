<?php
    //this are namespaces
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;

    use Slim\Views\PhpRenderer;

    $app->post('/close-session-control', function (Request $request, Response $response, $args){

        session_start();

        $data=$request->getParsedBody();

        $jsondata=json_encode($data);

        $response->getBody()->write($jsondata);


        return $response; //with header al principal, y en el principal controlar que si llega algo de aqui, poner bandera de session cerrada
    } );

?>