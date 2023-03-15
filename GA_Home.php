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
?>

<!DOCTYPE html>
<html lang="en" >
<head>

  
  <title>GA Home Page </title>

  <script src= "libraries/papaparse.min.js" ></script>
  <script type="text/javascript" src="libraries/jquery-3.6.0.min.js"></script>
  <script src="uploadCSV/uploadCSV.js"></script>
</head>

<body>

    <div class="title">Welcome Graduate Assistant!</div>
    <div class="menu">
        <ul>
            <li class="option">
                <a href="javascript:void(0)" class="btn">Home</a>
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