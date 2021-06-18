

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

        $baseUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

       

        //var_dump ($_SESSION);

        /*we check first of all if there are cookies and user is logged in, user is logged in is needed because one we log,
        we set that session var and then form is not more needed since we have our session with our user.
        otherwise also without cheking if user is logged in, form would be submitted without interruption each time we enter this route and cookies are seth.
        this time is only done when needed (when we open browser)
        */

        if( (isset($_COOKIE["user_name"]) && isset($_COOKIE["user_email"]) && isset($_COOKIE["user_password"])) && (!isset($_SESSION["is_user_logged"])) ) {


            $data = array("loginEmailName" => $_COOKIE["user_email"], "loginPassName" => $_COOKIE["user_password"]);

           /*we sent hidden inputs with mail and apss stored on the cookies to make login again. 
           the inputs will have same name and so as in small-login.php form, to make it easier
           
           then with javascript we sent it programatically with submit() method

           but must be done only one time to set the sessi
           */
?>
            <form method="post"  action="./login-control" id="check_cookies_form_id">



                <input type="hidden" class="form-control" id="loginEMailInputID" name="loginEmailName" value= <?php echo $_COOKIE["user_email"]; ?> >

                <input type="hidden" class="form-control" id="loginPasswordInputID" name="loginPassName" value=<?php echo $_COOKIE["user_password"]; ?> >




                <input type="hidden" id="login-form-incoming-id" name="login-form-incoming-name" value="YES">
            
            
            </form>
        
        <script> 

       // alert("hola");

           document.getElementById("check_cookies_form_id").submit();
        
        
        
        
        
         </script>

<?php
           


   // die();//TODO this doesnt work, lets see with curl or guzzle. Evryone uses curl so well see

           /* $_POST["loginEmailName"]= $_COOKIE["user_email"];
            $_POST["loginPassName"]=$_COOKIE["user_password"];

            $data = array("loginEmailName" => $_COOKIE["user_email"], "loginPassName" => $_COOKIE["user_password"]);

            var_dump($data);

            die();

            $_POST["loginEmailName"]= $_COOKIE["user_email"];
            $_POST["loginPassName"]=$_COOKIE["user_password"];

            $encodedRequest=json_encode($_POST);*/

            //var_dump($encodedRequest);

           // die();

         //  $response->getBody()->write($responsePost);//TODO     QUIZA HAYA QUE MANDAR EL POST CON CURL

          //  return $response->withHeader("Location", "./login-control");

        }

      
        
        if( empty($_SESSION)){

            
        
            session_destroy();

            $renderer = new PhpRenderer('../templates');

            return $renderer->render($response, "small-login.php", $args); 

        }

        if (isset($_SESSION['alert'])){

            if($_SESSION['alert']=="alert-danger"){

                        session_destroy();
        
                ?>
                        <div class="alert <?php echo $_SESSION['alert'] ?> " role="alert">
                            WRONG LOGIN, INVALID FORMED OR INCORRECT EMAIL/PASSWORD
                        </div>
                    
                <?php
        
                       

                        $renderer = new PhpRenderer('../templates');

                        return $renderer->render($response, "small-login.php", $args); 
            }

           

        }
            
       // TODO si la sesion esta vacia (primera vez), o el form esta mal, se muestra el template. primer caso sin aviso, segunda con él
      

        
       

           



        if( isset($_SESSION["valid_user"]) && $_SESSION['valid_user']=="yes" ){
        
            //TODO METER OTRA TEMPLATE CON LOS ENDPOINT YA AQUI
        
             if( ( isset($_SESSION['alert']) ) && ( $_SESSION['alert']=="alert-info" ) ){

        ?>

                <div class="alert <?php echo $_SESSION['alert'] ?> " role="alert">
                   welcome <?php echo $_SESSION['user_name'] ?>
                </div>
        <?php   
        
        /* MUST DESTROY THE SESSION VARIABLE FOR THE session alert info, TO AVOID FLAG BEING SHOW*/
                unset($_SESSION['alert']);

               // session_destroy(); /*TODO delete this, only for thests, must make a close session button when correctly logged on the endpoint template*/

             }

             $renderer = new PhpRenderer('../templates');

             return $renderer->render($response, "routes-table-view.php", $args); 

        }

       
        
        return $response;
      
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