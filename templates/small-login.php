<?php

    require "../controllers/login-form-validations.php";

   
    
?>



<!DOCTYPE HTML>  
    <html>
        <head>
       <!-- <link rel="stylesheet" href="../src/assets/css/forms.css">-->
        <style>.error {color: #FF0000;}</style>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
        </head>
        <body>

       <!-- <form method="POST" action="./login-control">
            <label>Name: <input name="name"></label>
            <label>Country: <input name="country"></label>
            <input type="submit">
        </form>-->

        <div class="container">
            <div class="row">
                <div class="col-sm">

                </div><!--col-->

                <div class="col-sm">

                <form method="POST" action="./login-control"> 
            
                    <div class="mb-3">
                        <p><h2>LOGIN </h2></p>
                    </div>
                    <div class="mb-3">
                        <label for="loginEMailInputIDLabel" class="form-label">Email address*</label>
                        <input type="email" class="form-control" id="loginEMailInputID" name="loginEmailName" required >
                        <span class="error">* <?php echo $emailErr;?></span>
                    </div>

                    <div class="mb-3">
                        <label for="loginPasswordInputIDLabel" class="form-label">Password*:</label> <!-- TODO look a way to show password when click a button-->
                        <input type="password" class="form-control" id="loginPasswordInputID" name="loginPassName" required>
                    </div>

                    

                    <div class="mb-3 form-check">
                        <label class="form-check-label" for="rememberMeInputLogInIdLabel">Remember me</label>

                        <input type="checkbox" class="form-check-input" id="rememberMeInputLogInId"> <!-- TODO install cookie when clicked -->
                    </div> 
                   

                    <input type="hidden" id="login-form-incoming-id" name="login-form-incoming-name" value="YES"> 
                    <button type="submit" class="btn btn-primary">Submit</button>

                </form>

                <div class="mb-3 ">

                    <a href="./register"> Not an account? Register now</a>
                </div> 

                </div><!--col-->
            
                <div class="col-sm">
                </div><!--col-->
            
            
            </div><!--row-->
        
        </div>
  

       
        </body>
    </html>