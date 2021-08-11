<?php

//this are namespaces
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use Slim\Views\PhpRenderer;




$app->post('/login-control', function (Request $request, Response $response, $args){

    /*if $_POST['login-form-incoming-name'] is set, we must hash the password, 
    otherwise NOT because we would hash the already hashed password*/

    $pass="";

  
    /*if a form is coming, we require the code to make the validations*/
    if( isset($_POST['login-form-incoming-name']) ){

            

        

        require "../controllers/login-form-validations.php";

        
         $pass=MD5($_POST["loginPassName"]);

        

     }

     /*once everything is correct regarding validations, we will have to check against database if email or pass exists on 
     the user dabatase*/

     $data = $request->getParsedBody();


     /*if we have no login form coming (that means, is the automatic form, with the values of the cookies inside hidden to restore the session),
     then we have to avoid hashing of pass again because we would hash the hashed pass*/

     if(isset($_POST['automatic-login-form-incoming-name'])){

      $cookieToken=$data['session-token-on-cookie-name'];


      $userObject=new User();

    

      $responseFromLogIn=$userObject->checkUserSessionWithCookieToken($cookieToken);/*this must be done with the $data*/

     

      

    
    /*
    
        if we have an user with that cookie token, we start session like after regular userLogin method
    
    */
      if(count($responseFromLogIn)>0){

        session_start();

        $_SESSION['id_user']=$responseFromLogIn[0]["id_user"];
        $_SESSION['user_name']=$responseFromLogIn[0]["user_name"];
        $_SESSION['user_email']=$responseFromLogIn[0]["user_email"];
        $_SESSION['session_token']=$responseFromLogIn[0]['session_token']; 

        $_SESSION['is_user_logged']=true;
        $_SESSION['valid_user']="yes";
        $_SESSION['message-to-display-on-alert']="Welcome";


        $jencoded=json_encode($responseFromLogIn);

       

     
        
          $response->getBody()->write($jencoded);

    
      

      

       
        return $response->withHeader("Location", "./");
      }else{

        session_destroy();

        return $response->withHeader("Location", "./");
      }

      

     }
     

    
     $userObject=new User();

     /*this will return a jsonencoded response, which we will write on the body of the reponse of this route*/
      $responseFromLogIn=$userObject->userLogin($data["loginEmailName"], $pass);/*this must be done with the $data*/

     

     
      
      /*
      
        if there is an user with such email and password ($responseFromLogIn is not null), 
        we 1-store everything on a session, 
          2-create a cookie if "remember" is clicked, 
          3-and redirect to ./
          
        else (if no user with such memail and/or pass)
          1-send message for an alert
          3-redirect to ./
         
      */

      if($responseFromLogIn != null){


        
        session_start();

        /*
        
          we set the token for this session. we still dont have the id_user on $_SESSION so
          we take it with $responseFromLogIn[0]["id_user"]

          also to be sure we obtain the same token we have inserted on set token and store it to the session, we overwrite the token
          obtained on the userLogin query 

          that is because we have done the query to retrieve all user data before, and the token we have on the responseFronLogin is different,
          it is the prior token.

          if $responseFromLogIn is not null, to the /, cause session or user is not valid

        */
        $responseFromLogIn[0]['session_token']=$userObject->setToken($responseFromLogIn[0]["id_user"]);
       
        if( isset($_POST["login_checkbox_name"]) ){


            setcookie("s-token",  $responseFromLogIn[0]['session_token'],time()+86400*30);


        

        }


       
        $_SESSION['id_user']=$responseFromLogIn[0]["id_user"];
        $_SESSION['user_name']=$responseFromLogIn[0]["user_name"];
        $_SESSION['user_email']=$responseFromLogIn[0]["user_email"];
        $_SESSION['session_token']=$responseFromLogIn[0]['session_token']; 

        $_SESSION['is_user_logged']=true;
        $_SESSION['valid_user']="yes";
        $_SESSION['message-to-display-on-alert']="Welcome";



        
       


       
        return $response->withHeader("Location", "./");

        

      }else {
        


         session_start();

        $_SESSION['message-to-display-on-alert']="Email or password incorrect, please try again";

        return $response->withHeader("Location", "./");
      }
    
    
});

/*

    to control if user reloads the page or try to access through URL without permission,
    we control also the get route

*/
$app->get('/login-control', function (Request $request, Response $response, $args){

  return $response->withHeader("Location", "./");

});


?>