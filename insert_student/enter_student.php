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
    echo "<br> This email address is already in the system. Please Go back.";
       echo "<br><a href ='insert_student.php'> Back </a><br>";
    }


   if ($count == 0) {
        $sql = "INSERT INTO csemaildb.Students VALUES (NULL, '$first_name', '$last_name', '$program', '$major1', ";
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
        
        echo $sql;

       if ($result){
           echo "Student" .$first_name. " " .$last_name. "has been added successfully";
           echo "<br><a href ='insert_student.php'> Back </a><br>";
           }
    
           else {
             echo "<br> An error has been encountered. Please Try again later.";
             echo "<br> " . mysqli_error($con);
            }
    
   }

    

    
    
}





?>