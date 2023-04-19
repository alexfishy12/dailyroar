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
  <link href="CSS/background_moving.css" rel="stylesheet" type="text/css"/>
  <link href="CSS/content.css" rel="stylesheet" type="text/css"/>
</head>

<body class="retro" background-image="assets/Background.png"  background-size="cover">
    
    <div class="title" style="text-align: center">
        <p>Welcome to the Daily Roar!</p>
    </div>
    <div class="content">
    <div class="logout">
        <a href="logout.php">logout</a>
    </div>

<div class="nes-container with-title is-centered" style="background:rgba(0,0,0,0.5);">
  <a href="uploadCSV/upload_CSV.php" class="nes-btn button_format">Upload Students CSV</a>
</div>
</div>
<div class="background_parent">
    <img class='pixel_perfect keanu' src='assets/Keanu_Walk_FULLSCREEN.gif'></img>
    <img class='pixel_perfect foreground primary-fg' src='assets/Foreground_1.png'></img>
    <img class='pixel_perfect foreground secondary-fg' src='assets/Foreground_2.png'></img>
    <img class='pixel_perfect foreground tertiary-fg' src='assets/Foreground_1.png'></img>
    <img class='pixel_perfect middleground primary-mg' src='assets/Middleground_2.png'></img>
    <img class='pixel_perfect middleground secondary-mg' src='assets/Middleground_2.png'></img>
    <img class='pixel_perfect middleground tertiary-mg' src='assets/Middleground_2.png'></img>
    <img class='pixel_perfect background' src='assets/Background.png'></img>
    </div>
</body>
</html>