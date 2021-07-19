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
            //TODO this can be done with  valitron, that way we could show this error also with the others.
            Now tisd password fields dowsnt match it shows only that error and not the rest despite there are more
        */

       

            
            $v = new Valitron\Validator($data);

          
            //first param is the rule name, second is the paran "name" as described on the form
            $v->rule('equals', 'password', 'confirm Password');

            $v->rule('lengthBetween', 'name',3,10);
            $v->rule('alpha', 'name');

            $v->rule('email', 'email');
            $v->rule('lengthBetween', 'password',6,10);

            
            if($v->validate()) {

                //insert user on database with a method

                $userObject=new User();

                $userObject->insertUser($data);


                $_SESSION['message-to-display-on-alert']="succesfully registered. please login";

                return $response->withHeader('Location', './');

                
            } else {
                // Errors
                print_r($v->errors());

               //echo $v->errors();

            
                
                $_SESSION['errors-array-for-alerts']=$v->errors();
                return $response->withHeader('Location', './register');
            }

       

        return $response;

    });
?>