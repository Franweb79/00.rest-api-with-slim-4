<?php

/*https://tryphp.w3schools.com/showphp.php?filename=demo_form_validation_required*/

//echo "hola";

    $email="";
    $emailErr="";

    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
    

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

   

        /*if we have a post request, we check if email is empty; if not empyt, if it is valid*/

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $isAllOK=true;

        if (empty($_POST["loginEmailName"])) {
             $emailErr = "Email is required";

             $isAllOK=false;
    

        } else {
            $email = test_input($_POST["loginEmailName"]);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";

                $isAllOK=false;
    
               
            }
        }
         
       // var_dump ($isAllOK);

       if($isAllOK){

            

            echo "tira pa ya jopder";
            header("Location: http://www.google.es"); /* TODO a ver esto como redirecciono bien*/
        }

        
    }

        
    

    

    

?>