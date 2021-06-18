<?php

//this are namespaces
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Slim\Views\PhpRenderer;

$app->post('/login-control', function (Request $request, Response $response, $args){

    $pass="";/*if $_POST['login-form-incoming-name'] is set, we must hash it, otherwise not because we would hash the hashed password*/

    
    /*if a form is coming, we require the code to make the validations*/
    if( isset($_POST['login-form-incoming-name']) ){

            

        // $response->getBody()->write($_POST['login-form-incoming-name']);

        // require "../controllers/login-form-validations.php";

        require "../controllers/login-form-validations.php";
     

         /*$renderer = new PhpRenderer('../templates');

         $renderer->render($response, "small-login.php", $args);*/

         //echo ($isAllOk);

        
         $pass=MD5($_POST["loginPassName"]);

        

     }

     /*once everything is correct regarding validations, we will have to check againt data base if email or pass exists on 
     the user dabatase*/

     $data = $request->getParsedBody();

     /*if we have no login form coming (that means, is the automatic form, with the values of the cookies inside hidden to restore the session),
     then we have to avoid hashing of pass again because we would hash the hashed pass*/

     if(isset($_POST['automatic-login-form-incoming-name'])){


      $pass=$data["loginPassName"];

      /*var_dump("no incoming form");

      die();*/

     }
     

    
     $userObject=new User();

     /*this will return a jsonencoded response, which we will write on the body of the reponse of this route*/
      $responseFromLogIn=$userObject->userLogin($data["loginEmailName"], $pass);/*this must be done with the $data*/

      var_dump($responseFromLogIn);
      
      /*if there is an user with such email and password, we store everything on a session, create a cookie if "remember" is clicked, redirect to ./ */

      if($responseFromLogIn != null){
      /*we need a string to be passed to getbody()->write, so we convert the incoming array on <json></json>*/

        
        session_start();

        //var_dump($responseFromLogIn);

      // var_dump($responseFromLogIn[0]["user_name"]);
       
        if( isset($_POST["login_checkbox_name"]) ){

         // echo "cheked";

          setcookie("user_name",$responseFromLogIn[0]["user_name"],time()+86400*30);
          setcookie("user_email",$responseFromLogIn[0]["user_email"],time()+86400*30);
          setcookie("user_password",$responseFromLogIn[0]["user_password"],time()+86400*30);

        }
       

        $_SESSION['user_name']=$responseFromLogIn[0]["user_name"];
        $_SESSION['user_email']=$responseFromLogIn[0]["user_email"];
        $_SESSION['is_user_logged']=true;
        $_SESSION['valid_user']="yes";
        $_SESSION['alert']="alert-info";


        /* TODO look how to pass an netire object to a session*/

        $jencoded=json_encode($responseFromLogIn);

       // var_dump ($jencoded);

        $response->getBody()->write($jencoded);

       // var_dump($response->getBody());

       
        return $response->withHeader("Location", "./");

        

      }else {
        /*if is null, to the /, cause session or user is not valid*/

        /* TODO MUST BE A RETURN REPSONSE HERE IF NO CORRECT USER*/

        
        /*SEND A FLAG OR A SESSION VAR OR SOMETHING TO TELL USER OR PASS IS WRONG, not invalid formed but wrong*/

        return $response->withHeader("Location", "./");
      }
    
    
    
    

     // return $response;

    //var_dump($data);

    //var_dump($data['loginEMailInputID']);

   // $responseJSONencoded=json_encode($data);
    
    //$html = var_export($data, true);
   // $response->getBody()->write($responseJSONencoded);

   // $response->getBody()->write($html);
   
  
   
    //return $response->withHeader('Content-Type', 'application/json');

   // return $response; 
});

/*TODO create a get Haz un route get para el login control que devuelve siempre al principal, porque no se p
Si el user esta logeado y tratamos de acceder desde la propia url, 
ues se debería quedar ahí (o sea, llamar al route post login control)*/

?>