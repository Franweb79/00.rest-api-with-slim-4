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

    // TODO maybe create a get route and force to go to the log
    //TODO also maybe for the post create a middleware to avoid accesing it when user is loggedin
   

    $app->post('/register-control', function( Request $request, Response $response){

       

            session_start();

            $data=$request->getParsedBody();

             /*
                check if email trying to be registered exists on database.
            */

            $emailExists=NULL;

            $userObject=new User();

            $emailExists= $userObject->checkIfEmailExists($data['email']);

            

            if($emailExists == NULL){

                
     
                $v = new Valitron\Validator($data);

              

            
                //first param is the rule name, second is the paran "name" as described on the form
                $v->rule('equals', 'password', 'confirm_Password');

                $v->rule('lengthBetween', 'name',3,10);
                $v->rule('alpha', 'name');

                $v->rule('email', 'email');
                $v->rule('lengthBetween', 'password',6,10);

                
                if($v->validate()) {

                    /*
                    
                        insert user on database with a method.
                        As the prior connection to check if e mail exists will be closed on that method, we open another
                    */

                  
                

                    $userObject->insertUser($data);


                    $_SESSION['message-to-display-on-alert']="succesfully registered. please login";

                    return $response->withHeader('Location', './');

                
                } else {
                    // Errors
                    print_r($v->errors());

                    //echo $v->errors();

                
                
                    $_SESSION['errors-for-alerts']=$v->errors();
                    return $response->withHeader('Location', './register');
            }



            }else{

                /*

                    we dont specify on message which field is used to check  if user exists or nor, 
                    it is mopre secure to prevent attacks not giving clues.

                    As  $_SESSION['errors-for-alerts'] is an array of arrays which will be iterated on register-for-view,
                    we set the message as an array of arrays because that way code on view  is more reusable
                    */
                $_SESSION['errors-for-alerts']=array(array("One user with that email already exists on our database, please check another"));

               
                return $response->withHeader('Location', './register');

            }

            


       

        return $response;

    });

    $app->get('/register-control', function( Request $request, Response $response){

        return $response->withHeader('Location', './');


    });
?>