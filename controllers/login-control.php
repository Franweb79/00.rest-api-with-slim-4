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

     /*this will return a jsonencoded response, which we will write on the body of the reponse of this route*/
      $responseFromLogIn=$userObject->userLogin($data["loginEmailName"], $data["loginPassName"]);/*this must be done with the $data*/

      //var_dump($responseFromLogIn);
      
      if($responseFromLogIn != null){
      /*we need a string to be passed to getbody()->write, so we convert the incoming array on <json></json>*/

        session_start();

        //var_dump($responseFromLogIn);

      // var_dump($responseFromLogIn[0]["user_name"]);
       
  

        $_SESSION['user_name']=$responseFromLogIn[0]["user_name"];
        $_SESSION['user_email']=$responseFromLogIn[0]["user_email"];
        $_SESSION['valid_user']="yes";
        $_SESSION['alert']="alert-info";


        /* TODO look how to pass an netire object to a session*/

        $jencoded=json_encode($responseFromLogIn);

       // var_dump ($jencoded);

        $response->getBody()->write($jencoded);

       // var_dump($response->getBody());

       
        return $response->withHeader("Location", "./");

        

      }
    
    
    
      /* TODO MUST BE A RETURN REPSONSE HERE IF NO CORRECT USER*/
    

      return $response;

    //var_dump($data);

    //var_dump($data['loginEMailInputID']);

   // $responseJSONencoded=json_encode($data);
    
    //$html = var_export($data, true);
   // $response->getBody()->write($responseJSONencoded);

   // $response->getBody()->write($html);
   
  
   
    //return $response->withHeader('Content-Type', 'application/json');

   // return $response; 
});

?>