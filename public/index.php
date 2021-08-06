

<?php

//TODO maybe we can refactor the item wuery codes on a model Item-model like the User-model.php on config
    
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

    // # include users route, must do AFTER the declaration of app instance, dont know why. I GUESS BECAUSE THE $app invoked 
    //on those routes still not exists until $app is created
    /*require '../src/routes/users/get-all-users.php';
    require '../src/routes/users/get-user.php';*/

    require '../src/routes/users/post-user.php';

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

    /*deleted this from the official example
    
    $app->add(new BasePathMiddleware($app));
    
    */

    /*and added this*/
    $app->setBasePath("/00.rest-api-with-slim-4/public");
    $app->addErrorMiddleware(true, true, true);

    $firstMiddleware=function(Request $request, RequestHandler $handler){

        $response = $handler->handle($request);

        $existingContent = (string) $response->getBody();

      //  $response = new Response();

        $response->getBody()->write("first middleware ". $existingContent);

      

        return $response;
    };

    $secondMiddleware=function(Request $request, RequestHandler $handler){

        $response = $handler->handle($request);

        $response->getBody()->write("second middleware");

        return $response;
    };
  
    /*$app->add($firstMiddleware);
    $app->add($secondMiddleware);*/


    // Define app routes
    $app->get('/', function (Request $request, Response $response, $args) {
       // $response->getBody()->write("Hello, world!");

        /*we use session_start() to recover prior sessions if they are

        */

       
       
        session_start();



        $baseUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

       

        //var_dump ($_SESSION);

        /*we check first of all if there are cookies and user is logged in, user is logged in, is needed because once we log,
        we set that session var and then login form is not more needed since we have our session with our user.
        otherwise also without cheking if user is logged in, form would be submitted without interruption each time we enter this route and cookies are seth.
        this time is only done when needed (when we open browser)
        */

        /*so, if we have the cookie and user is still 
        not logged in -that means, he has not entered password or he reopens browser when he was logged in*/

        if( (isset($_COOKIE["s-token"])) && (!isset($_SESSION["is_user_logged"]) )  ) {



           // $data = array("loginEmailName" => $_COOKIE["user_email"], "loginPassName" => $_COOKIE["user_password"]);

           /*we sent hidden inputs with mail and apss stored on the cookies to make login again. 
           the inputs will have same name and so as in small-login.php form, to make it easier
           
           then with javascript we sent it programatically with submit() method

           but must be done only one time to set the sessi
           */
?>
            <form method="post"  action="./login-control" id="check_cookies_form_id">




                <input type="hidden" class="form-control" id="session-token-on-cookie-id" name="session-token-on-cookie-name" value=<?php echo $_COOKIE["s-token"]; ?> >




                <input type="hidden" id="login-form-incoming-id" name="automatic-login-form-incoming-name" value="YES">
            
            
            </form>
        
        <script> 

       // alert("hola");

           document.getElementById("check_cookies_form_id").submit();
        
        
        
        
        
         </script>

<?php
           


        }/*else if( !isset($_COOKIE["s-token"])  && isset($_SESSION["is_user_logged"]) ){

            /*this is to prevent page being reloaded and if cookie is deleted whern user is logged in, if he does, then out to lgin,
             we make it on an else if to avoid
            
            it is executed when user is logged in but hasnt click "remember me", nbecause it would otherwise destroy the session 
            */
          //  session_destroy();

           // var_dump("cookie deleted and reloaded page");

            //die();

           // header('Location:./');
       // }

      
        
        if( empty($_SESSION)){

            
        
            session_destroy();

            $renderer = new PhpRenderer('../templates');

            return $renderer->render($response, "small-login.php", $args); 

        }

        /*
        
            TODO maybe when I finish i can refactor this following code for the alerts and not
            having to render the template or destrying session on each condition, but problem is the flag color 
            is different on many cases so we should make conditions anyway. at the moment i let it so

            but i think template show and session destroy can be at the end, check what can be outside

           

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

           

           

            

           /* 
                //TODO maybe when I finish I can use this lines to refactor the code and avoid them on each condition
                session_destroy();
           
            
                

                unset($_SESSION['message-to-display']);

                   and render template
                
            */

        }
            
      

        
       

           



        if( isset($_SESSION["valid_user"]) && $_SESSION['valid_user']=="yes" ){
        
        
             if( ( isset($_SESSION['message-to-display-on-alert']) ) && ( $_SESSION['message-to-display-on-alert']=="Welcome" ) ){

        ?>

                <div class="alert alert-info " role="alert">
                   welcome <?php echo $_SESSION['user_name'] ?>
                </div>
        <?php   
        
        /* must destroy the session variable to show a message on an alert, to avoid alert being shown again*/
                unset($_SESSION['message-to-display-on-alert']);


             }


             $renderer = new PhpRenderer('../templates');

             return $renderer->render($response, "routes-table-view.php", $args); 

        }

       
        
        return $response;
      
        /*$response->getBody()->write($html);
        
        return $response;*/
       //return $response->withHeader('Location', './login');
       
    });

    /*

        just to avoid errors if by some reason a POST request is received (should not).

        //TODO if in the future we find a POST request can be done to this main route, we 
        we will handle it. For now, everything seems to be controlled on the get route 

    */

    $app->post('/', function (Request $request, Response $response, $args) {

       
         
         return $response;
        
     });

    

    





   /* $app->get('/users', function ($request, $response, array $args) {

        $response->getBody()->write("path to get users");
        return $response;
        
    });*/

 


   
    

    // Run app
    $app->run();

    
    
?>


