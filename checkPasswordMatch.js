// Add change event handler to the input elements
$('#password1, #password2').on('change', function() {
    // Extract the values of the input elements
    var string1 = $('#password1').val();
    var string2 = $('#password2').val();
  
    // Compare the extracted strings
    if (string1 === string2) {
      console.log('Strings match.');
    } else {
      console.log('Strings do not match.');
    }
  });