<?php
$host="imc.kean.edu";
$username="csemail";
$password="2023CSemail";
$dbname="csemaildb";
$con = mysqli_connect($host,$username,$password,$dbname)
    or die("<br> Cannot connect to DB: $dbname on $host");
?>