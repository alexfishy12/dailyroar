<!DOCTYPE html>
<html lang="en" >
<head>
<title>Your Password Has Been Reset</title>
  <script src= "../libraries/papaparse.min.js" ></script>
  <script type="text/javascript" src="../libraries/jquery-3.6.0.min.js"></script>
  <script src="../uploadCSV/uploadCSV.js"></script>
  <link href="../CSS/font_family.css" rel="stylesheet">
  <link rel="stylesheet" href="../CSS/background_static.css">
  <link rel="stylesheet" href="../CSS/content.css">
  <link rel="icon" href="../assets/Keanu_head.svg">

    <link href="https://unpkg.com/nes.css@2.3.0/css/nes.min.css" rel="stylesheet" />
</head>
<body class="retro" background-image="assets/Background.png"  background-size="cover" style="background-color:#0c5eb3;">
    
    <div class="title" style="text-align: center">
        <p>Forgot Password</p>
    </div>
  
<div class="content">
<div class="logout">
                <a href="../index.php">Back To Login</a>
            </div>
<div class="nes-container with-title is-centered" style="background:rgba(0,0,0,0.5)">
  <p class="label">Reset Password</p>

<?php
  include "../dbconfig.php";

if (isset($_POST['password2'])){
    $newpassword = $_POST['password2'];
    $email = $_POST['Email'];
    $code = $_POST['Code'];

    // create a prepared statement
    $stmt = $con->prepare("CALL Change_Password(?, ?)");

    // bind the parameters
    $stmt->bind_param("ss", $email, $newpassword);

    // execute the statement
    if ($stmt->execute()) {

        echo "Your new password has been set.";
        $sql = "DELETE FROM csemaildb.PasswordCode WHERE Code = $code";
    } else {
        echo "Could not succesfully change your password: " . $stmt->error;
    }

    // close the statement and database connection
    $stmt->close();
    $con->close();
}
?>
</div>
</div>

<div class="background_parent">
      <img class='pixel_perfect keanu' src='../assets/Keanu_Idle_FULLSCREEN.gif'></img>
      <img class='pixel_perfect foreground primary-fg' src='../assets/Foreground_1.png'></img>
      <img class='pixel_perfect middleground primary-mg' src='../assets/Middleground_2.png'></img>
      <img class='pixel_perfect background' src='../assets/Background.png'></img>
  </div>

</body>
</html>