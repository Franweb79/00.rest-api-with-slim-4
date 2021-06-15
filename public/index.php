<html>
    <head>
    
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

    </head> <!--TODO mete el bootstrap mejor, anda-->
    <body></body>
</html>


<?php
    
    //this are namespaces
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
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
    require '../src/routes/users/get-all-users.php';
    require '../src/routes/users/get-user.php';
    require '../src/routes/users/post-user.php';

    //ITEMS ROUTES

    require '../src/routes/items/get-all-items.php';

    //log in and register route

    require '../src/routes/login.php';
    require '../controllers/login-control.php';

    require '../src/config/User-model.php';

    require '../src/routes/register.php';




    
    
   





    // Add Slim routing middleware
    $app->addRoutingMiddleware();

    /*deleted this from the official example
    
    $app->add(new BasePathMiddleware($app));
    
    */

    /*and added this*/
    $app->setBasePath("/00.rest-api-with-slim-4/public");
    $app->addErrorMiddleware(true, true, true);

    
  

    // Define app routes
    $app->get('/', function (Request $request, Response $response, $args) {
       // $response->getBody()->write("Hello, world!");

        /*we use session_start() to recover prior sessions if they are

        */
            session_start();
            
       
       if( isset($_SESSION['alert'])   ){

        
       

            if($_SESSION['alert']=="alert-danger"){
        
        ?>
                <div class="alert <?php echo $_SESSION['alert'] ?> " role="alert">
                    WRONG LOGIN, INVALID FORMED OR INCORRECT EMAIL/PASSWORD
                </div>
            
        <?php

                session_destroy();
            }

        }

       $renderer = new PhpRenderer('../templates');

       return $renderer->render($response, "small-login.php", $args); 
        /*$response->getBody()->write($html);
        
        return $response;*/
       //return $response->withHeader('Location', './login');
       
    });

    $app->post('/', function (Request $request, Response $response, $args) {

        /*if a login form is set, we render the template again to show errors if they are.*/

      
        
        
       /* if( isset($_POST['login-form-incoming-name']) ){

            

            // $response->getBody()->write($_POST['login-form-incoming-name']);
    
            // require "../controllers/login-form-validations.php";
    
    
         
    
             $renderer = new PhpRenderer('../templates');
    
             $renderer->render($response, "small-login.php", $args);
    
             //echo ($isAllOk);
    
            
    
    
    
            
                 
             
            
         
    
         }/
        
        
         /*$response->getBody()->write($html);*/
         
         return $response;
        //return $response->withHeader('Location', './login');
        
     });

    

    





   /* $app->get('/users', function ($request, $response, array $args) {

        $response->getBody()->write("path to get users");
        return $response;
        
    });*/

 


   
    

    // Run app
    $app->run();

?>