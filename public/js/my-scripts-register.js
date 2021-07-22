
var isHidden=true; //when we load the script is always hidden


var isHiddenConfirm=true; //for the function in case is the confirm password field


$( "#eye-icon-register" ).click(( event )=> {
   // alert( event.currentTarget === this ); // true

    //alert("hi");

    toogleHideShowPassonRegisterForm("#registerPasswordInputID1");

    console.log(isHidden);

    
  });

  $( "#eye-icon-register-confirm" ).click(( event )=> {
    // alert( event.currentTarget === this ); // true
 
     //alert("hi");
 
     toogleHideShowPassonRegisterForm();
 
     console.log(isHidden);
 
     
   });

 /*
    will be called when clicked the eye icon to show or hide the password, changing the input property
    on this case we will hide both passowrd inpout and confirm password input

  */
  function toogleHideShowPassonRegisterForm(){

    

    if(isHidden==true){



      $("#registerPasswordInputID1").prop("type", "text");
      $("#registerPasswordInputID2").prop("type", "text");

      isHidden=false;

     


    }else{

        $("#registerPasswordInputID1").prop("type", "password");
        $("#registerPasswordInputID2").prop("type", "password");


      isHidden=true;



    }


    

   

  }