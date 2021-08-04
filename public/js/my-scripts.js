
var isHidden=true; //when we load the script is always hidden

$( "#test-button" ).click(function( event ) {
    alert( event.currentTarget === this ); // true
  });

$( "#eye-icon-login-id" ).click(( event )=> {
   // alert( event.currentTarget === this ); // true

    //alert("hi");

    toogleHideShowPass("loginPasswordInputID");

    console.log(isHidden);

    
  });

  $( "#eye-icon-register-confirm" ).click(( event )=> {
    // alert( event.currentTarget === this ); // true
 
     //alert("hi");
 
     toogleHideShowPass("registerPasswordInputID1","registerPasswordInputID2");
 
     console.log(isHidden);
 
     
   });

 /*
    will be called when clicked the eye icon to show or hide the password, changing the input property.
    As it is usual that I forget to write the identifier with # when I pass as parameter (needed by the jqeuery sintax),
    I attached the # later inside the function.
    
    @params p_element_id_to_hide_1 -> used on login as well as on register views, will be the string
            of this input id. 
            p_element_id_to_hide_2 -> OPTIONAL (to set as optional we set it to 0 when passing it as parameter)
                                    will be used only on register form, will be the 'confirm password' input id
                
   

  */
  function toogleHideShowPass(p_element_id_to_hide_1,p_element_id_to_hide_2=0){

    
    let string_id_1="#"+p_element_id_to_hide_1;

    let string_id_2="";

    if(isHidden==true){

      $(string_id_1).prop("type", "text");

      console.log(p_element_id_to_hide_2);

      if(p_element_id_to_hide_2 !=0 ){

       

        string_id_2="#"+p_element_id_to_hide_2;

        $(string_id_2).prop("type", "text");

        console.log (string_id_2);


      }

      isHidden=false;


    }else{

      $(string_id_1).prop("type", "password");

      if(p_element_id_to_hide_2 !=0 ){

        string_id_2="#"+p_element_id_to_hide_2;

        $( string_id_2).prop("type", "password");

        console.log (string_id_2);


      }

      isHidden=true;



    }

   

  }