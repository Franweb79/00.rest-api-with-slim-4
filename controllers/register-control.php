<?php

    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    use Valitron\Validator as V;

    /* 
    
        this route validates the form to register a new user.
        It comes from register.php file.
        We use the valitron library to validfate fields:

        https://github.com/vlucas/valitron
    */ 

    $app->post('/register-control', function( Request $request, Response $response){

       

       session_start();

       $data=$request->getParsedBody();

       /*
            check if passowrd field and confirm password are the same.
        */

       if( $data["register-pass-input-1"] === $data["register-pass-input-2"]){

        //validate everything here, and hash the password

            
            $v = new Valitron\Validator($data);

            $v->rule('email', 'register-email-input-name');

            
            if($v->validate()) {
                echo "Yay! We're all good!";
            } else {
                // Errors
                print_r($v->errors());
            }

       }else{

            $_SESSION['pass-fields-not-equal']="yes";

            return $response->withHeader('Location', './register');

       }

      


       

        return $response;

    });
?>