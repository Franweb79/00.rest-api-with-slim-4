<!DOCTYPE HTML>  
    <html>
        <head>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
        </head>
        <body>

            <!--<form method="POST" action="./register-control">
                <label>Name: <input name="name"></label>
                <label>Country: <input name="country"></label>
                <input type="submit">
            </form>-->

            <div class="container">
                <div class="row">
                    <div class="col-sm">

                    </div><!--col-->

                    <div class="col-sm">

                        <form> <?php /* TODO habraa que hacer que si fallan las validaciones, me devuelva al register, y quiza haya que 
                        hacer otro php de validaciones del login si no conseguimos hacer una condicion para el header location segun de que ruta o algo 
                        asi haya venido la request 
                        
                        
                           

                            //TODO MAYBE we use a library https://github.com/vlucas/valitron
                            //TODO remember passowrd must be HASHED!

                        */
                        
                        ?>
                    
                            <div class="mb-3">
                                <p><h2>REGISTER </h2></p>
                            </div>
                            <div class="mb-3">
                                <label for="registerNameInputIDLabel" class="form-label">Name:</label>
                                <input type="text" class="form-control" id="registerNameInputID" aria-describedby="nameHelp" required>
                                <div id="nameHelp" class="form-text">Min 3 - max 10 characters. Only letters and whitespaces allowed</div>
                            </div>
                            <div class="mb-3">
                                <label for="registerNameInputIDLabel" class="form-label">Email address*</label>
                                <input type="email" class="form-control" id="registerEMailInputID" aria-describedby="emailHelp" required>
                                <div id="emailHelp" class="form-text">We'll never share your email with anyone else. Must contain a valid email address (with @ and .)</div>
                            </div>

                            <div class="mb-3">
                                <label for="registerPasswordInputID1Label" class="form-label">Password*</label>
                                <input type="password" class="form-control" id="registerPasswordInputID1" aria-describedby="passwordHelp" required>
                                <div id="passwordHelp" class="form-text">Please min 6-max 10 characters.</div>

                            </div>

                            <div class="mb-3">
                                <label for="registerPasswordInputID2Label" class="form-label"> Confirm Password*</label>
                                <input type="password" class="form-control" id="registerPasswordInputID2" aria-describedby="passwordHelp" required>
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