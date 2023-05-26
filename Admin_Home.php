<?php
session_start();
//if(!isset($_SESSION['account_type'])){
   // header("Location: index.php");
  //  exit;
//}
if($_SESSION['account_type']=="FA"){
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

  <meta charset="UTF-8">
  <title>Admin Home Page</title>
  <audio autoplay="" loop="" src="./Wii_Music.mp3"></audio>
  <link rel="icon" href="assets/Keanu_head.svg">
    <link href="https://unpkg.com/nes.css@2.3.0/css/nes.min.css" rel="stylesheet" />
	<link href="CSS/font_family.css" rel="stylesheet">
    <link href="CSS/background_moving.css" rel="stylesheet" type="text/css"/>
    <link href="CSS/content.css" rel="stylesheet" type="text/css"/>
</head>

<body class='retro' background-image="assets/Background.png"  background-size="cover">
  
    <div class="title">
         Welcome to the Daily Roar!
    </div>
    <div class="scroll">
        <div class="content">
            <div class="logout">
                <a href="logout.php"><span class="nes-text is-success">Logout</span></a>
            </div>
                
                <div class="nes-container with-title is-centered" style="background:rgba(0,0,0,0.5)">
                    <a href="chart_analysis/analysis.php" class="nes-btn button_format" style="margin:20px">Email Analysis</a>
                    <a href="create_user/create_user.php" class="nes-btn button_format" style="margin:20px">Create New User</a>
                </div>
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
