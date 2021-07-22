
var isHidden=true; //when we load the script is always hidden

$( "#test-button" ).click(function( event ) {
    alert( event.currentTarget === this ); // true
  });

$( "#eye-icon" ).click(( event )=> {
   // alert( event.currentTarget === this ); // true

    

    toogleHideShowPass();

    console.log(isHidden);

    
  });

 /*
    will be called when clicked the eye icon to show or hide the password, changing the input property
    @params p_is_hidden : a boolean to determine is pass must be shown or hidden

  */
  function toogleHideShowPass(){


    if(isHidden==true){

      $("#loginPasswordInputID").prop("type", "text");

      isHidden=false;


    }else{

      $("#loginPasswordInputID").prop("type", "password");

      isHidden=true;



    }

   

  }