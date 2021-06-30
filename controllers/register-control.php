<?php

    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    $app->post('/register-control', function( Request $request, Response $response){

       var_dump($request->getParsedBody());

       $data=$request->getParsedBody();

       var_dump($data["register-email-input-name"]);
       
        var_dump($response->getbody()->write("hola"));

        return $response;

    });
?>