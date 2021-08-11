<?php

    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    use Psr\Http\Server\RequestHandlerInterface as RequestHandler; //for the middleware

    use Valitron\Validator as V;
    
    use Slim\Views\PhpRenderer;

    /*
        user must be logged or token cookie to remember session created

    */

    $postItemControlMiddleware=function(Request $request, RequestHandler $handler){

        

        $response = $handler->handle($request);
        
        if(  !isset($_SESSION['is_user_logged']) && !isset($_COOKIE['s-token'])  ){

            
            

           // var_dump($_SESSION);
           
          // die();
        
            return $response->withHeader('Location', './');
        
        }else
        {
            return $response;
        }
    
    
    };

    /*
    
        we won´t allow accessing it through get, so we redirect to index.php 

        which should lead to routes-table-view.php
            
    */

    $app->get('/post-new-item-control', function (Request $request, Response $response, $args){ 
        
        return $response->withHeader('Location', './');
        
    });

    /* 
    
        to ensure this will only be done when a post-item form is sent, 
        if is coming a hidden field from that form called $_POST["create-item-form-incoming-name"] we will do tasks; 
        if not, to the index.php

    */
    $app->post('/post-new-item-control', function (Request $request, Response $response, $args){ 
        
       

        if($_POST["create-item-form-incoming-name"]){


            session_start();

            $data=$request->getParsedBody();
    
            var_dump($data);

            /*
                we start validating the data with valitron before inserting it to the database.
                Remember must have no whitespaces, only letters and number, min 3. max 10 characters.
                We will also check with REQUIRED that a field exists in the data array, and is not null or an empty string.

                https://github.com/vlucas/valitron

            */

            $v = new Valitron\Validator($data);

            $v->rule('required', 'itemName');

            $v->rule('alphaNum', 'itemName');

            $v->rule('lengthBetween', 'itemName', 3, 20);

            if($v->validate()) {

                $itemObject=new Item();

                $itemObject->postNewItem($data);

                //this will be shown on routes-table-view.php template

                /*

                    despite this $_SESSION value could be called the same as the one used to store the errors,
                    and then reuse the code used to show the alert with errors to show also item is succesfully registered,
                    since the alert color must be different, I had to create conditions on the view  to show a different color depending on
                    error or success inserting the item, so at the end there would be not so much code saving


                */

                $_SESSION['message-to-display-on-alert']="item succesfully registered";


                return $response->withHeader('Location', './');


            }else{
                
                print_r($v->errors());

                //this will be shown on the routes-table-view.php template
                $_SESSION['errors-for-alerts']=$v->errors();
                return $response->withHeader('Location', './');
            }


        }else{

            return $response->withHeader('Location', './');

        }

       
        
        
    })->add($postItemControlMiddleware);


?>