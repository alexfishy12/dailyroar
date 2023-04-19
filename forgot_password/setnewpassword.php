<!DOCTYPE html>
<html lang="en" >
<head>
<title>Your Password Has Been Reset</title>
  <script src= "libraries/papaparse.min.js" ></script>
  <script type="text/javascript" src="libraries/jquery-3.6.0.min.js"></script>
  <script src="uploadCSV/uploadCSV.js"></script>
  <link href="CSS/font_family.css" rel="stylesheet">
  <link href="CSS/faculty_home_page.css" rel="stylesheet">
    <link href="https://unpkg.com/nes.css@2.3.0/css/nes.min.css" rel="stylesheet" />
</head>
<body class="retro" style="margin-top:10vh; margin-bottom:30vh; margin-left:20vw; margin-right:20vw;">
    
    <div class="body" style="text-align: center">
        <p>Welcome to the Daily Roar!</p>
    </div>
  

<div class="nes-container with-title is-centered">
  <p class="title">Reset Password</p>

<?php
  include "../dbconfig.php";

if (isset($_POST['password2'])){
    $newpassword = $_POST['password2'];
    $email = $_POST['Email'];

    // create a prepared statement
    $stmt = $con->prepare("CALL Change_Password(?, ?)");

    // bind the parameters
    $stmt->bind_param("ss", $email, $newpassword);

    // execute the statement
    if ($stmt->execute()) {
        echo "Your new password has been set.";
    } else {
        echo "Could not succesfully change your password: " . $stmt->error;
    }

    // close the statement and database connection
    $stmt->close();
    $con->close();
}
?>
</div>



</body>
</html>