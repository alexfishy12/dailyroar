<?php
    include("dbconfig.php");
    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", "$dbuser","$dbpass");
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
        $query = "UPDATE Tracking set Opened = 1 where StudentID = :student_id AND EmailID = :email_id;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":student_id", $student_id);
        $stmt->bindParam(":email_id", $email_id);
        $stmt->execute();
        if ($stmt->errorCode() === '00000') {
            echo "Update successful<br>";
        } else {
            echo "Error: Update failed!<br>";
            echo $pdo->errorInfo()[2];
            die();
        }
    }
?>
