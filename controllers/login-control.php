<?php

//this are namespaces
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->post('/login-control', function (Request $request, Response $response, $args){
    $data = $request->getParsedBody();

    $jencoded=json_encode($data);
    var_dump($data['name']);

   // $responseJSONencoded=json_encode($data);
    
    $html = var_export($data, true);
   // $response->getBody()->write($responseJSONencoded);

    $response->getBody()->write($html);
   // var_dump($response->getBody());
    //return $response->withHeader('Content-Type', 'application/json');

    return $response;
});

?>