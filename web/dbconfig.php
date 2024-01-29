<?php
$dbhost="db";
$dbuser=$_ENV["MYSQL_USER"];
$dbpass=$_ENV["MYSQL_PASSWORD"];
$dbname="csemaildb";
$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)
    or die("<br> Cannot connect to DB: $dbname on $dbhost");
?>