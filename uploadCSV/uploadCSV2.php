<?php
include("dbconfig.php");


$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)
    or die("<br> Cannot connect to DB: $dbname on $host");



$jsonString = file_get_contents('php://input');

// decode the JSON payload into a PHP object
$data = json_decode($jsonString,true);

foreach($data as $val)
{
    // inserting active program
    $exisits_active_program = "SELECT ActiveProgram 
                                FROM ActiveProgram 
                                WHERE EXISTS (SELECT ActiveProgram FROM ActiveProgram 
                                WHERE ActiveProgram = '". $val["Active Programs"]."')";
    
    $result_active_program = mysqli_query($con, $exists_active_program);

    // if it is not in the table insert
    if($result_active_program)
    {
        if(mysqli_num_rows($result) <= 0)
        {
            $insert_active_program = "INSERT INTO csemaildb.ActiveProgram VALUES (NULL,'".$val["Active Programs"]."')";
            $result_insert_active_program = mysqli_query($con,$insert_active_program);

            if(!$result_insert_active_program)
                echo "Could not insert ". $val["Active Programs"];
        }
    }
    else 
        echo "Error fetching active programs";



}

?>