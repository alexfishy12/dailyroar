<?php
$user=strtolower($_POST['login_id']);
$pass=$_POST['password'];
include "dbconfig.php";
session_start();

$sql = "SELECT * FROM csemaildb.Login WHERE Email_Address = '$user' ";

$result = mysqli_query($con,$sql);

if(mysqli_num_rows($result)){
    $row = mysqli_fetch_array($result);
    if(strtolower($row['Email_Address'])== $user){
        if($row['Password']!=$pass){
            echo "Password incorrect <br> Login Failed!";
            header("refresh:2;url=index.php");
        }
        else{
            $_SESSION["user"] = $user;
            $_SESSION['account_type'] = $row['Account_Type'];
            $_SESSION['id'] = $row['ID'];
            if($_SESSION['account_type']=="FA"){
                header("Location: Faculty_Home.php");
            }
            else{
                header("location: GA_Home.php");
            }
        }
    }
}
else{
    echo "Authentication Error";
}
?>
