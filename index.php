<?php
session_start();
if(isset($_SESSION['account_type']) && $_SESSION['account_type']=="FA"){
	header("Location: Faculty_Home.php");
	exit;
	}
elseif(isset($_SESSION['account_type']) && $_SESSION['account_type']=="GA"){
	header("Location: GA_Home.php");
	exit;
	}
?>
<!DOCTYPE html>
<html lang="en" >
<head>

  <meta charset="UTF-8">
  <title>Daily Roar Login</title>
  <link href="CSS/style.css" rel="stylesheet" type="text/css"/>
<link href="CSS/font_family.css" rel="stylesheet">
    <link href="https://unpkg.com/nes.css@2.3.0/css/nes.min.css" rel="stylesheet" />
	<link href="CSS/font_family.css" rel="stylesheet">
	<link href="CSS/home.css" rel="stylesheet" type="text/css"/> 
</head>

<body class='retro'>
<div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->
    <h2 class="active"> Sign In </h2>
    <!-- Icon -->
    <div class="fadeIn first">
      <img src="assets/Kean_University_Logo.svg.png" alt="Kean Logo" height="70" width="70"/>
    </div>
    <!-- Login Form -->
    <form name="input" action="login.php" method="post">
      <input type="text" class="fadeIn second" name="login_id" placeholder="Username" required="required">
      <input type="password" class="fadeIn third" name="password" placeholder="Password" required="required">
      <input type="submit" class="fadeIn fourth" value="login">
    </form>
    <!-- Remind Passowrd -->
    <div id="formFooter">
      <a class="underlineHover" href="forgot_password.php">Forgot Password?</a>
    </div>

  </div>
</div>

</body>
</html>
