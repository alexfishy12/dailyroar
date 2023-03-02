<?php
    include "dbconfig.php";
    $connect = new PDO("mysql:host=$dbhost;dbname=$dbname", "$dbuser","$dbpassword");
    $email_id = null;
    $student_id = null;

    if(isset($_GET["email_id"])) {
        $email_id = $_GET["email_id"];
    } else {
        echo "Error: email_id not set<br>";
    }
    if(isset($_GET["student_id"])) {
        $student_id = $_GET["student_id"];
    } else {
        echo "Error: student_id not set<br>";
    }

    if ($email_id && $student_id) {
        $query = "INSERT INTO Tracking (student_id, email_id, Opened) VALUES (?, ?, ?)";
        $statement = $connect->prepare($query);
        if ($statement->execute([$student_id, $email_id, 1])) {
            echo "Insert successful<br>";
        } else {
            echo "Error: insert failed<br>";
        }
    }
?>
