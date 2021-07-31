<?php




?>

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
            <link href="css/styles.css" rel="stylesheet" >

        </head>
        <body>


            <div class="container">
                <div class="row">

                    <div class="col-sm"></div>
                    <div class="col-sm">
                        <p></p>
                        <h2>CREATE A NEW ITEM</h2>

                        
                        <form method="POST" action="./post-new-item-control">

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="form-group">
                                    <div class="login-input">
                                        <label class="control-label sr-only" for="item-name"></label>
                                        <p>Please only numbers and letters allowed. No whitespaces. Min 3 max. 20 characters</p>
                                        <input type="text" name="itemName" placeholder="enter a name for your item" class="form-control"  required/>
                                        <div class="book-icon"><i class="fa fa-book"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mb20">

                                    <?php  /*this hidden is to include the validations file later on an if statement*/ ?>
                                    <input type="hidden" id="login-form-incoming-id" name="create-item-form-incoming-name" value="YES"> 
                                    <button type="submit" class="btn btn-primary btn-block mb10">CREATE ITEM</button>
                                        
                            </div>
                               


                        </form>
                        <a href="./" class="btn btn-primary btn-block mb10" style="margin-top:20px; background-color:#0069D9">BACK</a>



                    </div><!--col-->
                    <div class="col-sm"></div>
                </div><!--row-->
            </div><!--container-->
        </body>

    </html>
