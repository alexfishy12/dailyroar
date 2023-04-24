<?php
session_start();
if(!isset($_SESSION['account_type'])){
    header("Location: ../index.php");
	exit;
}
$now=time();
if($now > $_SESSION['expire']) {
    session_destroy();
    header("Location: ../index.php");  
}

if(isset($_SESSION['account_type'])&& $_SESSION['account_type']=="FA"){
    include("../faculty_nav.php");
}
else{
    include("../GA_Nav.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daily Roar - Upload CSV</title>
  <script src= "../libraries/papaparse.min.js" ></script>
  <script type="text/javascript" src="../libraries/jquery-3.6.0.min.js"></script>
  <script src="uploadCSV.js"></script>
  <link rel="icon" href="../assets/Keanu_head.svg">
  <link href="../CSS/font_family.css" rel="stylesheet">
  <link href="../CSS/content.css" rel="stylesheet">
  <link href="../CSS/background_static.css" rel="stylesheet">
  <link href="https://unpkg.com/nes.css@2.3.0/css/nes.min.css" rel="stylesheet"/>
</head>

<body class='retro' background-image="../assets/Background.png"  background-size="cover" style="background-color:#0c5eb3;">
  
<div class="title">
    <p>Upload Students CSV</P>
</div>
<div class="scroll">
    <div class="content">
        <div class= "csvDownload" >
           <a href="Daily Roar Student Upload Template.csv" download ><span class="nes-text is-success">Download CSV Template</span></a>
         </div>
            <div class="nes-container with-title is-centered">
                <div>
                    <input type = "file" id = "uploadcsv" name = "uploadcsv" accept=".csv">
                    <button id="upload" class="nes-btn is-primary" style="margin-top:25px;margin-bottom:25px;">Upload CSV</button>
                </div>
                <div id="loading_message" style="margin-top:25px;margin-bottom:25px;"></div>
                <div id="responseMessage" style="margin-top:25px;margin-bottom:25px;"></div>
            </div>
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