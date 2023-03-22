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

<body>

    <h2 class="title" >Welcome Faculty Member </h2>
    <br>
    <div class = "squareGrid">

        <div class = "navOption" href = "google.com">
           <h3 class = "navTitle"><a href = "Faculty_Home.php"> Home </a></h3>
        </div>

        <div class="navOption">
            <h3 class = "navTitle"><a href = "send_email/email.php"> Email </a> </h3>
        </div>

        <div class="navOption">
            <h3 class = "navTitle"><a href = "insert_student/insert_student.php"> Manually Insert </a> </h3>
        </div>


        <div class="navOption">
            <h3 class = "navTitle"><a href = "update_students/update_student.php"> Update a Student </h3>
        </div>

        <div class="navOption">
            <h3 class = "navTitle"> <a href = "uploadCSV/upload_csv.php"> Upload Students CSV </a></h3>
        </div>

    </div>
</body>
</html>
