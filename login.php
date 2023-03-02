<?php
$user=strtolower($_POST['login_id']);
$pass=$_POST['password'];

include "dbconfig.php";

$con = mysqli_connect($host,$username,$password,$dbname)
    or die("<br> Cannot connect to DB: $dbname on $host");

$sql = "SELECT * FROM csemaildb.Login WHERE Email_Address = '$user' ";

$result = mysqli_query($con,$sql);

if(mysqli_num_rows($result)){
    $row = mysqli_fetch_array($result);
    if(strtolower($row['Email_Address'])== $user){
        if($row['Password']!=$pass){
            echo "Password incorrect <br> Login Failed!";
            header("refresh:3;url=index.html");
        }
        else{
            header("refresh:0;url=home.html");   ;
        }
    }
}
else{
    echo "Authentication Error";
}
?>