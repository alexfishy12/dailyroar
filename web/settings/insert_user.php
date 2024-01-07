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
<html lang="en">
    <head>
        <title>Daily Roar - Insert User</title>
        <link rel="icon" href="../_assets/Keanu_head.svg">
        <link href="../_CSS/font_family.css" rel="stylesheet">
        <link href="https://unpkg.com/nes.css@2.3.0/css/nes.min.css" rel="stylesheet"/>
        <link href="../_CSS/background_static.css" rel="stylesheet">
        <link href="../_CSS/content.css" rel="stylesheet">
    </head>
    <?php include("../faculty_nav.php");?>
<body class="retro" background-image="../_assets/Background.png"  background-size="cover" style="background-color:#0c5eb3;">
<div class="background_parent">
      <img class='pixel_perfect keanu' src='../_assets/Keanu_Idle_FULLSCREEN.gif'></img>
      <img class='pixel_perfect foreground primary-fg' src='../_assets/Foreground_1.png'></img>
      <img class='pixel_perfect middleground primary-mg' src='../_assets/Middleground_2.png'></img>
      <img class='pixel_perfect background' src='../_assets/Background.png'></img>
</div>
    <div class="subtitle" style="text-align: center;">
        <p>Insert New User</p>
    </div>
    <div class="content">
    <div class="logout">
                <a href="create_user.php"><span class="nes-text is-success">Go Back</span></a>
            </div>
<div class="nes-container with-title is-centered">

<?php 
include "../dbconfig.php";

echo "Feature disabled for demo purposes.";
die();

if(isset($_SESSION['account_type']) && $_SESSION['account_type']== "FA"){

    if(isset($_POST['f_name'])){
        $fname = $_POST['f_name'];
    }
    else{
        echo "First name not set";
        die();
    }

    if(isset($_POST['l_name'])){
        $lname = $_POST['l_name'];
    }
    else{
        echo "Last name not set";
        die();
    }

    if(isset($_POST['acc_type'])){
        $acc_type = $_POST['acc_type'];
    }
    else{
        echo "Account type not set";
        die();
    }

    if(isset($_POST['email'])){
        $email = $_POST['email'];
    }
    else{
        echo "Email Address not set";
        die();
    }

    if(isset($_POST['password1'])){
        $pass = $_POST['password1'];
    }
    else{
        echo "Password not set";
    }

    $query = "SELECT Email_Address FROM Login WHERE Email_Address = '$email'";
    $result = mysqli_query($con,$query);
    $count = mysqli_num_rows($result);

    if($count > 0){
        echo "<div class='label'> This User already Exists! Please go Back.</div> ";
    }
    elseif($count == 0){
        $sql="CALL Add_Login('$acc_type', '$email', '$pass', '$fname', '$lname');";
        $result = mysqli_query($con,$sql);

        if($result){
            echo "<div class='label'> User ".$fname." ".$lname." has been successfully added to the system.</div>";
        }
        else{
            echo "<br><div class='label'>An error has occurred. Please try again Later.</div>";
        }

    }
}
?>
</div>
</div>
</body> 
</html>