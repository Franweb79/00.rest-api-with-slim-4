<?php

?>

<!DOCTYPE HTML>  
    <html>
        <head>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
        </head>
        <body>

            <?php echo "soy el table" ?>

            <div class="list-group">
            
                <div>
                    
                    <span class="badge badge-primary badge-pill">1</span>
                </div>
            </div>

            <div class="container">
  <div class="row">
    <div class="col-sm">
    <?php 
    
    $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    echo  $url; ?>

        <a href="<?php echo $url.'get-all-items' ?>" target="_blank"class="list-group-item list-group-item-action list-group-item-light"> GET ITEMS</a>
        <a href="<?php echo $url ?>" class="list-group-item list-group-item-action list-group-item-light">GET AN ITEM</a>
        <a href="<?php echo $url ?>" class="list-group-item list-group-item-action list-group-item-light">POST ITEM </a>      
    </div>
    <div class="col-sm">
  
    </div>
    <div class="col-sm">
     
    </div>
  </div>
</div>

         
        </body>
    </html>