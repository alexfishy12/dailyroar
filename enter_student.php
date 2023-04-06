<?php
include "dbconfig.php";
$con = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname) or die("<br>Cannot connect to DB:$dbname on $dbhost\n");

if(isset($_COOKIE['account_type']) && $_COOKIE['account_type']== "FA" ){
    if (isset($_POST["first_name"]))
    {
        $first_name = ($_POST['first_name']); 
    }

    if (isset($_POST["last_name"]))
    {
        $last_name = ($_POST['last_name']);
    }

    if (isset($_POST["active_program"]))
    {
        $program = ($_POST['active_program']);   
    }

    if (isset($_POST["major1"]))
    {
        $major1 = ($_POST['major1']); 
    }

    if (isset($_POST["major2"]))
    {
        $major2 = ($_POST['major2']);   
    }

    if (isset($_POST["minor"]))
    {
        $minor = ($_POST['minor']);   
    }

    if (isset($_POST["class_stand"]))
    {
        $class = ($_POST['class_stand']);   
    }

    if (isset($_POST["email"]))
    {
        $email = ($_POST['email']);
    }


    $sqlcheck ="SELECT EmailAddress FROM Students WHERE EmailAddress = '$email';";
    $resultcheck = mysqli_query($con, $sqlcheck);
    $count = mysqli_num_rows($resultcheck);
    


   if ($count > 0){
    echo "<br> This email address is already in the system. Please Go back.";
       echo "<br><a href ='insert_student.php'> Back </a><br>";
    }

   if ($count == 0) {
        $sql = "INSERT INTO csemaildb.Students VALUES (NULL, '$first_name', '$last_name', '$program', '$major1', '$major2', '$minor', '$class', '$email')";
        $result = mysqli_query($con, $sql);
        
    

       if ($result){
           echo "Student" .$first_name. " " .$last_name. "has been added successfully";
           echo "<br><a href ='insert_student.php'> Back </a><br>";
           }
    
           else {
             echo "<br> An error has been encountered. Please Try again later.";
            }
    
   }

    

    
    
}





?>