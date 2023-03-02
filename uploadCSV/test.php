<?php 

$jsonString = file_get_contents('php://input');

// decode the JSON payload into a PHP object
$data = json_decode($jsonString);


echo $data;

echo $jsonString;
?>