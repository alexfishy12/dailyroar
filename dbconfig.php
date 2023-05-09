<?php
$dbhost="imc.kean.edu";
$dbuser="csemail";
$dbpass="2023CSemail";
$dbname="csemaildb2";
$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)
    or die("<br> Cannot connect to DB: $dbname on $dbhost");
?>