<?php

/*https://tryphp.w3schools.com/showphp.php?filename=demo_form_validation_required*/

echo "hola";

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $email="";
    $emailErr="";

    /*if we have a post request, we check if email is empty; if not empyt, if it is valid*/

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (empty($_POST["loginEmailName"])) {
            $emailErr = "Email is required";
          } else {
            $email = test_input($_POST["loginEmailName"]);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            }
          }
         

         
    }

?>