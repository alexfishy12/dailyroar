<!DOCTYPE html>
<html lang="en" >
<head>
<title>Daily Roar - Insert New Student</title>
  <link href="../_CSS/font_family.css" rel="stylesheet">
  <link rel="stylesheet" href="../_CSS/background_static.css">
  <link rel="stylesheet" href="../_CSS/content.css">
    <link href="https://unpkg.com/nes.css@2.3.0/css/nes.min.css" rel="stylesheet"/>
    </head>
<body class="retro" background-image="../_assets/Background.png"  background-size="cover" style="background-color:#0c5eb3;">
<div class="subtitle" style="text-align: center">
        <p>Insert a New Student</p>
    </div>
<div class="content">
<div class="logout">
                <a href="insert_student.php"><span class="nes-text is-success">Go Back</span></a>
            </div>
<div class="nes-container with-title is-centered">
<?php
include "../dbconfig.php";

session_start();
$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die("<br>Cannot connect to DB:$dbname on $dbhost\n");

if(isset($_SESSION['account_type']) && $_SESSION['account_type']== "FA" ){
    if (isset($_POST["first_name"]))
    {
        $first_name = ($_POST['first_name']); 
    }
    else {
        echo "First name not set.";
        die();
    }

    if (isset($_POST["last_name"]))
    {
        $last_name = ($_POST['last_name']);
    }
    else {
        echo "Last name not set.";
        die();
    }

    if (isset($_POST["active_program"]))
    {
        $program = ($_POST['active_program']);   
    }
    else {
        echo "Active Program not set.";
        die();
    }

    if (isset($_POST["major1"]))
    {
        $major1 = ($_POST['major1']); 
    }
    else {
        echo "Major 1 not set.";
        die();
    }

    if (isset($_POST["major2"]))
    {
        $major2 = ($_POST['major2']);   
    }
    else {
        echo "Major 2 not set.";
        die();
    }

    if (isset($_POST["minor"]))
    {
        $minor = ($_POST['minor']);   
    }
    else {
        echo "Minor not set.";
        die();
    }

    if (isset($_POST["class_stand"]))
    {
        $class = ($_POST['class_stand']);   
    }
    else {
        echo "Class standing not set.";
        die();
    }

    if (isset($_POST["email"]))
    {
        $email = ($_POST['email']);
    }
    else {
        echo "Email not set.";
        die();
    }

    $sqlcheck ="SELECT EmailAddress FROM Students WHERE EmailAddress = '$email';";
    $resultcheck = mysqli_query($con, $sqlcheck);
    $count = mysqli_num_rows($resultcheck);


   if ($count > 0){
        echo "<div class='label'>This email address is already in the system. Please Go back.</div>";
    }


   if ($count == 0) {
        $sql = "INSERT INTO Students VALUES (NULL, '$first_name', '$last_name', '$program', '$major1', ";
        if (empty($major2)) {
            $sql = $sql . "NULL, ";
        }
        else {
            $sql = $sql . "'$major2', ";
        }
        if (empty($minor)) {
            $sql = $sql . "NULL, ";
        }
        else {
            $sql = $sql . "'$minor', ";
        }
        if (empty($class)) {
            $sql = $sql . "NULL, ";
        }
        else {
            $sql = $sql . "'$class', ";
        }
        $sql = $sql . "'$email');";
        $result = mysqli_query($con, $sql);

       if ($result){
           echo "<div class='label'>Student " .$first_name. " " .$last_name. " has been added successfully.</div>";
           }
    
           else {
             echo "<br><div class='label'> An error has been encountered. Please Try again later.</div>";
             echo "<br> " . mysqli_error($con);
            }
    
   }

    

    
    
}
?>
</div>
</div>
<div class="background_parent">
      <img class='pixel_perfect keanu' src='../_assets/Keanu_Idle_FULLSCREEN.gif'></img>
      <img class='pixel_perfect foreground primary-fg' src='../_assets/Foreground_1.png'></img>
      <img class='pixel_perfect middleground primary-mg' src='../_assets/Middleground_2.png'></img>
      <img class='pixel_perfect background' src='../_assets/Background.png'></img>
  </div>
</body> 
</html>