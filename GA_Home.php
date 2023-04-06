<?php
session_start();
if(!isset($_SESSION['account_type'])){
    header("Location: index.php");
    exit;
}
elseif(isset($_SESSION['account_type']) && $_SESSION['account_type']=="FA"){
    header("Location: Faculty_Home.php");
    exit;
}
$now=time();
if($now > $_SESSION['expire']) {
    session_destroy();
    header("Location: index.php");  
}
?>
<!DOCTYPE html>
<html lang="en" >
<head>

  
  <title>GA Home Page </title>
  <audio autoplay="" loop="" src="./Wii_Music.mp3"></audio>
  <script src= "libraries/papaparse.min.js" ></script>
  <script type="text/javascript" src="libraries/jquery-3.6.0.min.js"></script>
  <script src="uploadCSV/uploadCSV.js"></script>
  <link href="/dailyroar/CSS/font_family.css" rel="stylesheet">
  <link href="https://unpkg.com/nes.css@2.3.0/css/nes.min.css" rel="stylesheet" /> 
  <link href="CSS/faculty_home_page.css" rel="stylesheet">
  <link href="CSS/font_family.css" rel="stylesheet">
</head>

<body class="retro" style="margin-top:10vh; margin-bottom:30vh; margin-left:20vw; margin-right:20vw;">
    
    <div class="body" style="text-align: center">
        <p>Welcome to the Daily Roar!</p>
    </div>
    <div class="logout">
        <a href="logout.php">logout</a>
    </div>

<div class="nes-container with-title is-centered">
  <p class="title">Select an Option</p>
  <a href="uploadCSV/upload_GA.php" class="nes-btn button_format" style="margin:20px">Upload Students CSV</a>
</div>
</body>
</html>