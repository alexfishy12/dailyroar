<?php
session_start();
if(!isset($_SESSION['account_type'])){
    header("Location: ../index.php");
	exit;
}
elseif(isset($_SESSION['account_type']) && $_SESSION['account_type']=="GA"){
    header("Location: ../GA_Home.php");
    exit;
}
$now=time();
if($now > $_SESSION['expire']) {
    session_destroy();
    header("Location: ../index.php");  
}
?>
<!DOCTYPE html>
<html lang="en" >
<head>

  
  <title>Daily Roar - Upload CSV</title>


  <script src= "../libraries/papaparse.min.js" ></script>
  <script type="text/javascript" src="../libraries/jquery-3.6.0.min.js"></script>
  <script src="uploadCSV.js"></script>
  <link href="../CSS/font_family.css" rel="stylesheet">
  <link href="https://unpkg.com/nes.css@2.3.0/css/nes.min.css" rel="stylesheet" />
</head>

<?php 
include("../faculty_nav.php");
?>

<body class="retro">

    <div class="title">Upload Students CSV</div>

    <div>
        <input type = "file" id = "uploadcsv" name = "uploadcsv" onchange = "readCSV();">
    </div>
    <div id="responseMessage"></div>



</body>
</html>