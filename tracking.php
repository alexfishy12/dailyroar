<?php
    include("dbconfig.php");
    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", "$dbuser","$dbpass");
    $email_id = null;
    $student_id = null;
    $tracking_type = null;
    $redirect_url = null;
    $die = false;
    $decoded_url = null;

    if(isset($_GET["email_id"])) {
        $email_id = $_GET["email_id"];
    } else {
        echo "Error: email_id not set<br>";
        $die = true;
    }
    if(isset($_GET["student_id"])) {
        $student_id = $_GET["student_id"];
    } else {
        echo "Error: student_id not set<br>";
        $die = true;
    }
    if(isset($_GET["tracking_type"])) {
        
        $tracking_type = $_GET["tracking_type"];
        if ($tracking_type != "click" && $tracking_type != "open") {
            echo "Error: Invalid tracking type<br>";
            die();
        }
        if ($tracking_type != "open") {
            if (!isset($_GET["redirect_url"])) {
                echo "Error: redirect_url not set<br>";
                die();
            }
    
            $redirect_url = $_GET["redirect_url"];
    
            $decoded_url = urldecode($redirect_url);
            echo "Decoded URL: ". $decoded_url . "<br>";
        } 
    } else {
        echo "Error: tracking_type not set<br>";
        $die = true;
    }

    // if any errors occurred, do not continue the program
    if ($die == true) die();

    $query;
    if ($tracking_type == "open") {
        $query = "UPDATE Tracking set Opened = 1 where StudentID = :student_id AND EmailID = :email_id;";
    }
    else {
        $query = "UPDATE Tracking set Clicked = 1 where StudentID = :student_id AND EmailID = :email_id;";
    }
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":student_id", $student_id);
    $stmt->bindParam(":email_id", $email_id);
    $stmt->execute();
    if ($stmt->errorCode() === '00000') {
        //check to see if any records were changed
        if ($stmt->rowCount() > 0) {
            echo "Update successful<br>";
        }
        else {
            echo "No record found to update.";
        }
    } else {
        echo "Error: Update failed!<br>";
        echo $pdo->errorInfo()[2];
    }

    header("Location: " .$decoded_url);
    exit;
?>
