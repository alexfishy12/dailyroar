<?php
session_start();
if(!isset($_SESSION['account_type'])){
    header("Location: index.php");
    exit;
}
elseif($_SESSION['account_type']=="GA"){
    header("Location: GA_Home.php");
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

  
  <title>Faculty Home Page</title>

  <audio autoplay="" loop="" src="./Wii_Music.mp3"></audio>
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
    <div class="logout">
        <a href="logout.php">logout</a>
    </div>

<div class="nes-container with-title is-centered">
  <p class="title">Select an Option</p>
  <a href="send_email/email.php" class="nes-btn button_format" style="margin:20px">Compose Email</a>
  <a href="insert_student/insert_student.php" class="nes-btn button_format" style="margin:20px">Manually Insert a Student</a><br>
  <a href="update_students/update_student.php" class="nes-btn button_format" style="margin:20px">Update a Student</a>
  <a href="uploadCSV/upload_CSV.php" class="nes-btn button_format" style="margin:20px">Upload Students CSV</a>
  <a href="#" class="nes-btn" style="margin:20px">Chart Analysis</a>
</div>

<style> 
.background {
  width: 100vh;
  height: 100vw;
  background-color: red;
  position: absolute;
  animation-name: example;
  animation-duration: 4s;
  animation-iteration-count: 3;
}

@keyframes example {
  0%   {background-color:red; left:0px; top:0px;}
  25%  {background-color:yellow; left:200px; top:0px;}
  50%  {background-color:blue; left:200px; top:200px;}
  75%  {background-color:green; left:0px; top:200px;}
  100% {background-color:red; left:0px; top:0px;}
}
</style>

</body>
</html>
