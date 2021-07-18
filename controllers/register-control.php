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

       if( $data["password"] === $data["register-pass-input-2-name"]){

        //validate everything here

            
            $v = new Valitron\Validator($data);

          
            //first param is the rule name, second is the paran "name" as described on the form


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

       }else{


            /* 

                since v->errors() returns ar array of arrays, if we want to use the same code
                to control and show alerts with erros, we must pass here 
                an array of arrays to emulate what v->errors() make
            */
            
            $_SESSION['errors-array-for-alerts']=array(array("Password fields don´t match"));

            return $response->withHeader('Location', './register');

       }

      


       

        return $response;

    });
?>