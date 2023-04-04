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
  <link href="/dailyroar/CSS/font_family.css" rel="stylesheet">
    <link href="https://unpkg.com/nes.css@2.3.0/css/nes.min.css" rel="stylesheet" />
</head>

<body class="retro">
    
    <div class="body">
        <p>Welcome to the Daily Roar!</p>
    </div>
    <div class="logout">
        <a href="logout.php">logout</a>
    </div>

<div class="nes-container with-title is-centered">
  <p class="title">Select an Option</p>
  <a href="javascript:void(0)" class="nes-btn">Home</a>
  <a href="send_email/email.php" class="nes-btn">Email</a>
  <a href="insert_student/insert_student.php" class="nes-btn">Manually Insert a Student</a>
  <a href="update_students/update_student.php" class="nes-btn">Update a Student</a>
  <a href="uploadCSV/uploadCSV.html" class="nes-btn">Upload Students CSV</a>
</div>

</body>
</html>
