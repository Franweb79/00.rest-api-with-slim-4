<?php
    //this are namespaces
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;

    use Slim\Views\PhpRenderer;

    $app->post('/close-session-control', function (Request $request, Response $response, $args){

        

        $data=$request->getParsedBody();

        $jsondata=json_encode($data);

        $response->getBody()->write($jsondata);


        return $response;
    } );

?>