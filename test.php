<form>
  <label for="password">Enter password:</label>
  <input type="password" id="password" name="password" required>

  <label for="confirm-password">Confirm password:</label>
  <input type="password" id="confirm-password" name="confirm-password" required 
         pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
         oninput="checkPasswordMatch()">

  <div id="password-match"></div>

  <input type="submit" value="Submit">
</form>";

<script>
function checkPasswordMatch() {
  var password = document.getElementById("password");
  var confirm_password = document.getElementById("confirm-password");
  var message_div = document.getElementById("password-match");

  if (password.value != confirm_password.value) {
    message_div.innerHTML = "Passwords do not match.";
    confirm_password.setCustomValidity("Passwords do not match.");
  } else {
    message_div.innerHTML = "Passwords match.";
    confirm_password.setCustomValidity("");
  }
}
</script>
