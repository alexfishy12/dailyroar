document.addEventListener('DOMContentLoaded', function() {
// Get the input elements for password fields
var password1 = document.getElementById('password1');
var password2 = document.getElementById('password2');

// Get the message element for displaying password match message
var passwordMatchMessage = document.getElementById('passwordMatchMessage');

// Get the submit button element 
var submitButton = document.getElementById("submit-button");

// Add event listener for "input" event on password2 field
password2.addEventListener('input', checkPasswordsMatch);

// Add event listener fot "submit" event



// Function to check password match
function checkPasswordsMatch() {
 
  // Retrieve the values of both password fields
  var password1Value = password1.value;
  var password2Value = password2.value;

  // Compare the password values

    if (password1Value === password2Value)
    {
      
      passwordMatchMessage.textContent = 'Passwords match';
      submitButton.disabled = false;

    } else 
    {
      
      passwordMatchMessage.textContent = 'Passwords do not match';
      submitButton.disabled = true;
      
    }

}

})
