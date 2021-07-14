<!DOCTYPE HTML>  
    <html>
        <head>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
        </head>
        <body>


            <div class="container">

                <?php
                           
                     //TODO remember passowrd must be HASHED!


                        if(isset ($_SESSION['pass-fields-not-equal']) ){
                ?>
                            <div class="alert alert-danger" role="alert">
                                Password fields don´t match
                            </div>
                 <?php
                            session_destroy();
                        }

                ?>
                
                <div class="row">
                    <div class="col-sm">

                    </div><!--col-->

                    <div class="col-sm">

                        <form method="post" action="./register-control">
                    
                            
                            <div class="mb-3">
                                <p><h2>REGISTER </h2></p>
                            </div>
                            <div class="mb-3">
                                <label for="registerNameInputIDLabel" class="form-label">Name:</label>
                                <input type="text" class="form-control" id="registerNameInputID" name="register-name-input-name" aria-describedby="nameHelp" required>
                                <div id="nameHelp" class="form-text">Min 3 - max 10 characters. Only letters and whitespaces allowed</div>
                            </div>
                            <div class="mb-3">
                                <label for="registerNameInputIDLabel" class="form-label">Email address*</label>
                                <input type="email" class="form-control" id="registerEMailInputID" name="register-email-input-name" aria-describedby="emailHelp" required>
                                <div id="emailHelp" class="form-text">We'll never share your email with anyone else. Must contain a valid email address (with @ and .)</div>
                            </div>

                            <div class="mb-3">
                                <label for="registerPasswordInputID1Label" class="form-label">Password*</label>
                                <input type="password" class="form-control" id="registerPasswordInputID1" name="register-pass-input-1" aria-describedby="passwordHelp" required>
                                <div id="passwordHelp" class="form-text">Please min 6-max 10 characters.</div>

                            </div>

                            <div class="mb-3">
                                <label for="registerPasswordInputID2Label" class="form-label"> Confirm Password*</label>
                                <input type="password" class="form-control" id="registerPasswordInputID2" name="register-pass-input-2" aria-describedby="passwordHelp" required>
                                <div id="passwordHelp" class="form-text">Please min 6-max 10 characters.</div>

                            </div>

                            


                            <button type="submit" class="btn btn-primary">Submit</button>

                        </form>


                    </div><!--col-->
                
                    <div class="col-sm">
                    </div><!--col-->
                
                
                </div><!--row-->
            
            </div>
  

       
        </body>
    </html>