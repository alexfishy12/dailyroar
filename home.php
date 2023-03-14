<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en" >
<head>

  
  <title>Daily Roar Login</title>

  <script src= "libraries/papaparse.min.js" ></script>
  <script type="text/javascript" src="libraries/jquery-3.6.0.min.js"></script>
  <script src="uploadCSV/uploadCSV.js"></script>
</head>

<body>

    <div class="title">Daily Roar - Home</div>
    <div class="menu">
        <ul>
            <li class="option">
                <a href="javascript:void(0)" class="btn">Home</a>
            </li>
            <li class="option">
                <a href="send_email/email.php" class="btn">Email</a>
            </li>
            <li class="option">
                <a href="insert_student/insert_student.php" class="btn">Manually Insert a Student</a>
            </li>
            <li class="option">
                <a href="update_students/update_student.html" class="btn">Update a Student</a>
            </li>
            <li class="option">
                <a href="uploadCSV/uploadCSV.html" class="btn">Upload Students CSV</a>
            </li>
        </ul>
    </div>
    <div class="body">
        <p>Welcome to the Daily Roar!</p>
    </div>
    <div class="logout">
        <a href="logout.php">logout</a>
    </div>
</body>
</html>
