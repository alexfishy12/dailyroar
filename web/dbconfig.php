<?php
$dbhost="db";
$dbuser=$_ENV["MYSQL_USER"];
$dbpass=$_ENV["MYSQL_PASSWORD"];
$dbname=$_ENV["MYSQL_DATABASE"];
$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)
    or die("<br> Cannot connect to DB: $dbname on $dbhost");
?>