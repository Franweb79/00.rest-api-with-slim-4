//alert("test js");

$( "#test-button" ).click(function( event ) {
    alert( event.currentTarget === this ); // true
  });