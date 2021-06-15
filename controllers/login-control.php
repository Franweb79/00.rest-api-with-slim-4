<?php

//this are namespaces
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Slim\Views\PhpRenderer;

$app->post('/login-control', function (Request $request, Response $response, $args){

    
    /*if a form is coming, we require the code to make the validations*/
    if( isset($_POST['login-form-incoming-name']) ){

            

        // $response->getBody()->write($_POST['login-form-incoming-name']);

        // require "../controllers/login-form-validations.php";

        require "../controllers/login-form-validations.php";
     

         /*$renderer = new PhpRenderer('../templates');

         $renderer->render($response, "small-login.php", $args);*/

         //echo ($isAllOk);

        
     

     }

     /*once everything is correct regarding validations, we will have to check againt data base if email or pass exists on 
     the user dabatase*/

     $data = $request->getParsedBody();

     

    
     $userObject=new User();

     $userObject->userLogin($data["loginEmailName"], $data["loginPassName"]);/*this must be done with the $data*/  

    
     die();
   

    //var_dump($data);

    $jencoded=json_encode($data);
    //var_dump($data['loginEMailInputID']);

   // $responseJSONencoded=json_encode($data);
    
    $html = var_export($data, true);
   // $response->getBody()->write($responseJSONencoded);

    $response->getBody()->write($html);
   
    /*TODO por aqui habra que meter los datos a la base de datos y luego redirigir al index que muestre los endpoints*/
   
    //return $response->withHeader('Content-Type', 'application/json');

    return $response; 
});

?>