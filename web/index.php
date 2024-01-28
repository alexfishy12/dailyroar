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
  <link rel="icon" href="_assets/Keanu_head.svg">
  <link href="_CSS/style.css" rel="stylesheet" type="text/css"/>
  <link href="https://unpkg.com/nes.css@2.3.0/css/nes.min.css" rel="stylesheet" />
	<link href="_CSS/font_family.css" rel="stylesheet">
  <link href="_CSS/background_moving.css" rel="stylesheet" type="text/css"/>

  <script type="text/javascript" src="_libraries/jquery-3.6.0.min.js"></script>
  <script src="_functions.js"></script>
  <script src="index.js" type="text/javascript"></script>
</head>

<body class='retro' background-image="_assets/Background.png"  background-size="cover">
  <div class="wrapper fadeInDown">
  <div class="title">The Daily Roar</div>
  <br>
  <div class="subtitle">"Onward and Upward!"</div>
  <br>
    <div id="formContent">
      <!-- Tabs Titles -->
      <h2 class="active"> Sign In </h2>
      <!-- Icon -->
      <div class="fadeIn first">
        <img src="_assets/Kean_University_Logo.svg.png" alt="Kean Logo" height="70" width="70"/>
      </div>
      <!-- Login Form -->
      <form name="input" id="login" method="POST">
        <input id="login_id" type="text" class="fadeIn second" name="login_id" placeholder="Username" required="required">
        <input id="password" type="password" class="fadeIn third" name="password" placeholder="Password" required="required">
        <input type="submit" class="fadeIn fourth" value="login">
      </form>
      <div id="errorMessage" style='color:red'>
      </div>
      <!-- Remind Passowrd -->
      <div id="formFooter">
        <a class="underlineHover" href="forgot_password/forgot_password.php">Forgot Password?</a>
        <br><br>
        <p class="nes-text" style="color:gray;"><u>Demo Accounts</u></p>
        <div class="text-left justify-content-center align-items-center" style="font-size: 13px;">
          <p>
              <b style="color:gray;">Faculty</b><br>
              <span style="color:gray">Username: </span>demo@faculty.edu<br>
              <span style="color:gray">Password: </span>password
          </p>
          <p>
              <b style="color:gray;">Graduate Assistant</b><br>
              <span style="color:gray">Username: </span>demo@graduate.edu<br>
              <span style="color:gray">Password: </span>password
          </p>
        </div>
      </div>

    </div>
  </div>
  <div class="background_parent">
    <img class='pixel_perfect keanu' src='_assets/Keanu_Walk_FULLSCREEN.gif'></img>
    <img class='pixel_perfect foreground primary-fg' src='_assets/Foreground_1.png'></img>
    <img class='pixel_perfect foreground secondary-fg' src='_assets/Foreground_2.png'></img>
    <img class='pixel_perfect foreground tertiary-fg' src='_assets/Foreground_1.png'></img>
    <img class='pixel_perfect middleground primary-mg' src='_assets/Middleground_2.png'></img>
    <img class='pixel_perfect middleground secondary-mg' src='_assets/Middleground_2.png'></img>
    <img class='pixel_perfect middleground tertiary-mg' src='_assets/Middleground_2.png'></img>
    <img class='pixel_perfect background' src='_assets/Background.png'></img>
  </div>
</body>
</html>