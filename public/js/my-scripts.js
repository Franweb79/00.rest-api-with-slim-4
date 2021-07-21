//alert("test js");

$( "#test-button" ).click(function( event ) {
    alert( event.currentTarget === this ); // true
  });

  $( "#eye-icon" ).click(function( event ) {
    alert( event.currentTarget === this ); // true
  });