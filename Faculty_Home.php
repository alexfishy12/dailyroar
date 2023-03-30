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
?>
<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<link rel="icon" type="image/x-icon" href="assets/Kean_University_Logo_Nav.ico">
  
  <title>Faculty Home Page</title>

  <audio autoplay="" loop="" src="./Wii_Music.mp3"></audio>

  <link href="https://unpkg.com/nes.css/css/nes.css" rel="stylesheet" />
  <link rel="stylesheet" href="/dailyroar/CSS/faculty_home_page.css">
  <script src= "libraries/papaparse.min.js" ></script>
  <script type="text/javascript" src="libraries/jquery-3.6.0.min.js"></script>
  <script src="uploadCSV/uploadCSV.js"></script>

  <style>

        .navOption {
            width: 180px;
            height: 180px;
            background: rgb(223, 219, 219);
            border: 1px solid black;
            display: inline-block;
            cursor: pointer;
            
            
        }

        .navTitle{

            text-align: center;
            padding-top: 50px;
        }

        .title{

            text-align: center;
            padding-top: 30vh;
   
        
        }

        .squareGrid{

            padding-left: 10vw;
        }


  </style>

</head>

<body class="retro" style="margin-top:40vh;margin-bottom:40vh;">

<div class="nes-container with-title is-centered" style="margin-left: 5vw; margin-right: 5vw;">
    <p class="title">The Daily Roar</p>
    <a class="nes-btn" href = "Faculty_Home.php"> Home </a>
    <a class="nes-btn" href = "send_email/email.php"> Email </a>
    <a class="nes-btn" href = "insert_student/insert_student.php"> Manually Insert </a>
    <a class="nes-btn" href = "update_students/update_student.php"> Update a Student</a>
    <a class="nes-btn" href = "uploadCSV/upload_csv.php"> Upload Students CSV </a>
</div>
        
</body>
</html>
