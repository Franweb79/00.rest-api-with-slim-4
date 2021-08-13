

<?php

    
    //this are namespaces
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Server\RequestHandlerInterface as RequestHandler; //for the middleware
    use Selective\BasePath\BasePathMiddleware;
    use Psr\Http\Message\ResponseInterface;
    use Slim\Exception\HttpNotFoundException;
    use Slim\Factory\AppFactory;
    use Selective\BasePath\BasePathDetector;


    use Slim\Views\PhpRenderer;

    //include the SLIM framework

    require_once __DIR__ . '/../vendor/autoload.php';

     // include DB connection file (at the moment dev one, later production one when finished, on my own host)
    require '../src/config/db-connection-dev.php';

    //create SLIM instance, on slim 4 is so:

    $app = AppFactory::create();


    /* 
    
        #  routes, must be done AFTER the declaration of app instance, dont know why. I GUESS BECAUSE THE $app invoked 
        on those routes still not exists until $app is created

    */


    /*
    
        require '../src/routes/users/get-all-users.php';
        require '../src/routes/users/get-user.php';
        
    */

   // require '../src/routes/users/post-user.php';

    //ITEMS ROUTES

    require '../src/routes/items/get-all-items.php';
    require '../src/routes/items/get-item.php';
    require '../src/routes/items/post-new-item.php';
    require '..//controllers/post-new-item-control.php';

    //log in and register route, as well as the user and item class models

    
    require '../controllers/login-control.php';

    require '../src/config/User-model.php';
    require '../src/config/Item-model.php';

    require '../src/routes/register.php';
    require '..//controllers/register-control.php';


    //logout route

    require '../controllers/close-session-control.php';


?>
   

 <?php  





    
    
   





    // Add Slim routing middleware
    $app->addRoutingMiddleware();

    /*
    
        deleted this from the official example
    
        $app->add(new BasePathMiddleware($app));
    
    */

    /*and added this*/
    $app->setBasePath("/00.rest-api-with-slim-4/public");
    $app->addErrorMiddleware(true, true, true);

    /* 

        some middlewares to test

    */

    $firstMiddleware=function(Request $request, RequestHandler $handler){

        $response = $handler->handle($request);

        $existingContent = (string) $response->getBody();

      

        $response->getBody()->write("first middleware ". $existingContent);

      

        return $response;
    };

    $secondMiddleware=function(Request $request, RequestHandler $handler){

        $response = $handler->handle($request);

        $response->getBody()->write("second middleware");

        return $response;
    };
  
    /*
    
        $app->add($firstMiddleware);
        $app->add($secondMiddleware);
        
    */


    // Define app routes
    $app->get('/', function (Request $request, Response $response, $args) {
       

        /*
        
            we use session_start() to recover prior sessions if they are

        */

       
       
        session_start();



        $baseUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

       

        /*
        
            we check first of all if there are cookies and user is logged in, user is logged in, is needed because once we log,
            we set that session var and then login form is not more needed since we have our session with our user.
            otherwise also without cheking if user is logged in, form would be submitted without interruption each time we enter this route and cookies are seth.
            this time is only done when needed (when we open browser)
        */

        /*
        
            so, if we have the cookie and user is still 
            not logged in -that means, he has not entered password 
            or he reopens browser when he was logged in
            
        */

        if( (isset($_COOKIE["s-token"])) && (!isset($_SESSION["is_user_logged"]) )  ) {


           /*
           
                we sent hidden inputs with mail and apss stored on the cookies to make login again. 
                the inputs will have same name and so as in small-login.php form, to make it easier,
                then with javascript we sent it programatically with submit() method
                but must be done only one time to set the session

           */
?>
            <form method="post"  action="./login-control" id="check_cookies_form_id">




                <input type="hidden" class="form-control" id="session-token-on-cookie-id" name="session-token-on-cookie-name" value=<?php echo $_COOKIE["s-token"]; ?> >




                <input type="hidden" id="login-form-incoming-id" name="automatic-login-form-incoming-name" value="YES">
            
            
            </form>
        
        <script> 

       

           document.getElementById("check_cookies_form_id").submit();
        
        
        
        
        
         </script>

<?php
           


        }
        
        
        if( empty($_SESSION)){

            
        
            session_destroy();

            $renderer = new PhpRenderer('../templates');

            return $renderer->render($response, "small-login.php", $args); 

        }

        /*
        
            TODO maybe when I can refactor this following code for the alerts and not
            having to render the template or destroying session on each condition, but problem is the flag color 
            is different on many cases so we should make conditions anyway. So, at the moment it will stay this way
           
            Also maybe the template rendering and redirection to the small-login.php can be at the end 
            instead of evaluating it on every condition, since it seems to be evaluated on all the conditions,
            will check someday

        */

        if (isset($_SESSION['message-to-display-on-alert'])){

        

    
            

            if( $_SESSION['message-to-display-on-alert']==" WRONG LOGIN, INVALID FORMED EMAIL"){

                    
        
                ?>
                    <div class="alert alert-danger " role="alert">
                        <?php echo $_SESSION['message-to-display-on-alert']; ?>
                    </div>
                    
                <?php
        
                    session_destroy();   

                        $renderer = new PhpRenderer('../templates');

                        return $renderer->render($response, "small-login.php", $args); 
            }

            else if($_SESSION['message-to-display-on-alert']=="Closed session"){

              
        
                ?>
                    <div class="alert alert-info" role="alert">
                        <?php echo $_SESSION['message-to-display-on-alert']; ?>
                    </div>
                    
                <?php
        
                     session_destroy();

                    $renderer = new PhpRenderer('../templates');

                    return $renderer->render($response, "small-login.php", $args); 



            }

            else if($_SESSION['message-to-display-on-alert']=="succesfully registered. please login"){

                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $_SESSION['message-to-display-on-alert']; ?>
                    </div>

                <?php

                    session_destroy();

                    $renderer = new PhpRenderer('../templates');

                    return $renderer->render($response, "small-login.php", $args); 

                
            }
            else if($_SESSION['message-to-display-on-alert']=="Email or password incorrect, please try again"){

                ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $_SESSION['message-to-display-on-alert']; ?>
                </div>

            <?php

                session_destroy();

                $renderer = new PhpRenderer('../templates');

                return $renderer->render($response, "small-login.php", $args); 


            }

            

        }
            
      

        
       

           



        if( isset($_SESSION["valid_user"]) && $_SESSION['valid_user']=="yes" ){
        
        
             if( ( isset($_SESSION['message-to-display-on-alert']) ) && ( $_SESSION['message-to-display-on-alert']=="Welcome" ) ){

        ?>

                <div class="alert alert-info " role="alert">
                   welcome <?php echo $_SESSION['user_name'] ?>
                </div>
        <?php   
        
        /* 
        
            must destroy the session variable to show a message on an alert, 
            to avoid alert being shown again
            
        */
                unset($_SESSION['message-to-display-on-alert']);


             }


             $renderer = new PhpRenderer('../templates');

             return $renderer->render($response, "routes-table-view.php", $args); 

        }

       
        
        return $response;
      
        ;
       
    });

    /*

        just to avoid errors if by some reason a POST request is received (should not).

    */

    $app->post('/', function (Request $request, Response $response, $args) {

       
         
         return $response;
        
     });

    

    // Run app
    $app->run();

    
    
?>


