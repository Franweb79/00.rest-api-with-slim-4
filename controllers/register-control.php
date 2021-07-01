<?php

    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;

    use Valitron\Validator as V;

    $app->post('/register-control', function( Request $request, Response $response){

       var_dump($request->getParsedBody());

      

       $data=$request->getParsedBody();

      // $v = new Valitron\Validator($_POST);

      $v = new Valitron\Validator($data);

       $v->rule('email', 'register-email-input-name');

       //var_dump($data["register-email-input-name"]);

       if($v->validate()) {
            echo "Yay! We're all good!";
        } else {
        // Errors
            print_r($v->errors());
        }
       
       // var_dump($response->getbody()->write("hola"));

        return $response;

    });
?>