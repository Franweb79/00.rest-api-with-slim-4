<!DOCTYPE HTML>  
    <html>
        <head>
            <script
			    src="https://code.jquery.com/jquery-3.6.0.min.js"
			    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
			    crossorigin="anonymous"></script>

            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

            <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
            <link href="css/styles-register.css" rel="stylesheet" >
        </head>
        <body>


            <div class="container">

                <?php
                           
                     /*
                        TODO maybe we can change styles to be able to show things like "min 6 max 10 outside the input, then is easier
                        when we see on mobile or responsive because otherwise you can´t see the whole text
                        
                    */




                        if(isset ($_SESSION['errors-for-alerts']) ){

                           
                ?>
                            <div class="alert alert-danger" role="alert">

                                <ul>
                                
                                
                                <?php 
                                    /*

                                        as the v->errors() of the valitron library returns an array with another array for each error,
                                        we must iterate twice 

                                    */
                                
                                
                                    foreach($_SESSION['errors-for-alerts'] as $arrayValueWithEachSingleError){

                                        foreach ($arrayValueWithEachSingleError as $key => $value )
                                        {

                                ?>
                                     <li>
                                         <?php echo $value; ?>
                                     </li>
                                           
                                        
                                <?php  
                                        }

                                    }
                                
                                ?>
                                </ul>
                                
                                
                            </div>
                 <?php
                            session_destroy();
                        }

                ?>
                
                <div class="row">
                    <div class="col">

                        <a href="./" class="btn btn-primary btn-block mb10" style="margin-top:20px; background-color:#0069D9">BACK</a>


                    </div><!--col-->

                    <div class="col-6">

                        <form method="post" action="./register-control">
                    
                            
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <p><h2>REGISTER USER</h2></p>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">

                                    <div class="login-input">
                                        

                                            <label for="registerNameInputIDLabel" class="control-label sr-only">Name:</label>
                                            <p>Your name. Min 3 - max 10 characters. Only letters allowed. No whitespaces, symbols or numbers</p>
                                            <input type="text" class="form-control" id="registerNameInputID" name="name" aria-describedby="nameHelp" required>
                                            <div class="login-icon"><i class="fa fa-user"></i></div>
                                        
                                    </div>   

                                    

                                </div>
                                
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">

                                   
                                    <div class="login-input">
                                            <label for="registerNameInputIDLabel" class="control-label sr-only">Email address*</label>
                                            <p>Your email. Must contain a valid email address</p>
                                            <input type="email" class="form-control" id="registerEMailInputID" name="email" aria-describedby="emailHelp" required>
                                            <div class="login-icon"><i class="fa fa-envelope"></i></div>

                                            


                                    </div>   

                                   
                                        
                                </div>
                                
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">

                                    
                                    <div class="login-input">
                                            <label for="registerPasswordInputID1Label" class="control-label sr-only">Password*</label>
                                            <p>Password. min 6-max 10 characters.</p>
                                            <input type="password" class="form-control" id="registerPasswordInputID1" name="password" aria-describedby="passwordHelp" required>
                                            <div class="login-icon"><i class="fa fa-lock" ></i></div>
                                            <div class="eye-icon"><button type="button" id="eye-icon-register-confirm"><i class="fa fa-eye" ></i></button></div>
                                        
                                            
                                    </div>   

                                    
                                </div>
                                

                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">

                                    <div class="login-input">

                                        <label for="registerPasswordInputID2Label" class="control-label sr-only"> Confirm Password*</label>
                                        <p>Repeat password</p>
                                        <input type="password" class="form-control" id="registerPasswordInputID2" name="confirm_Password" aria-describedby="passwordHelp" required>
                                        <div class="login-icon"><i class="fa fa-lock" ></i></div>


                                    
                                    </div>
                                  
                                    
                                </div>
                                

                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb20 ">
                                <br/>

                                <button type="submit" class="btn btn-primary btn-block mb10">Submit</button>
                            </div>

                        </form>


                    </div><!--col-->
                
                    <div class="col">
                    </div><!--col-->
                
                
                </div><!--row-->
            
            </div>
  
            <script src="js/obfuscated.js" type="text/javascript"></script>
       
        </body>
    </html>