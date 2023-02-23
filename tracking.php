<?php

    $connect = new PDO("mysql:host=imc.kean.edu;dbname=csemaildb", "csemail","2023CSemail");
    $emailID = null;
    $studentID = null;

    if(isset($_GET["emailID"])) {
        $emailID = $_GET["emailID"];
    } else {
        echo "Error: emailID not set<br>";
    }
    if(isset($_GET["studentID"])) {
        $studentID = $_GET["studentID"];
    } else {
        echo "Error: studentID not set<br>";
    }

    if ($emailID && $studentID) {
        $query = "INSERT INTO Tracking (studentID, emailID, Opened) VALUES (?, ?, ?)";
        $statement = $connect->prepare($query);
        if ($statement->execute([$studentID, $emailID, 1])) {
            echo "Insert successful<br>";
        } else {
            echo "Error: insert failed<br>";
        }
    }
?>
