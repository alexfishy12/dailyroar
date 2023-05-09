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
    header("Location: ../index.php");  
}
echo "<title id='title'>Daily Roar - Create User</title>";
include("../dbconfig.php");
?>

<!DOCTYPE html>
<html lang="en" >
    <head>
    <meta charset="UTF-8">
        <link rel="icon" href="../assets/Keanu_head.svg">
        <link href="../CSS/font_family.css" rel="stylesheet">
        <link href="https://unpkg.com/nes.css@2.3.0/css/nes.min.css" rel="stylesheet" />
        <link href="../CSS/background_static.css" rel="stylesheet">
        <link href="../CSS/content.css" rel="stylesheet">
        <script src="../forgot_password/checkPasswordMatch.js"></script>
        <?php include("../faculty_nav.php");?>
</head>

<body class="retro" style="background-color:#0c5eb3;">

<div class="title">
    <p>Change Active Semester</p>
</div>

<div class="scroll">
    <div class="content">
        <div class="nes-container with-title is-centered">
            <div id="active_semester">
                
            </div>
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