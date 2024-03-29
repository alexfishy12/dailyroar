<?php
    include("dbconfig.php");
    include("_functions.php");
    try {
        $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", "$dbuser","$dbpass");
        $email_id = null;
        $student_id = null;
        $tracking_type = null;
        $redirect_url = null;
        $die = false;
        $decoded_url = null;

        if(!isset($_GET["email_id"])) {
            $die = true;
            echo "Error: email_id not set<br>";
        } 
        if(!isset($_GET["student_id"])) {
            echo "Error: student_id not set<br>";
            $die = true;
        }

        if(!isset($_GET["tracking_type"])) {
            echo "Error: tracking_type not set<br>";
            $die = true;   
        }
        $tracking_type = $_GET["tracking_type"];
        if ($tracking_type != "click" && $tracking_type != "open") {
            echo "Error: Invalid tracking type<br>";
            $die = true;
        }

        $email_id = $_GET["email_id"];
        $student_id = $_GET["student_id"];
        
        if ($tracking_type != "open") {
            if (!isset($_GET["redirect_url"])) {
                echo "Error: redirect_url not set<br>";
            }
            else {
                $redirect_url = $_GET["redirect_url"];
                $decoded_url = urldecode($redirect_url);
                echo "Decoded URL: ". $decoded_url . "<br>";
            }
        } 

        // if any errors occurred, do not continue the program
        if ($die == false) {
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
            if ($stmt->errorCode() !== '00000') {
                echo "Error: Update failed!<br>";
                echo $pdo->errorInfo()[2];
            } else {
                //check to see if any records were changed
                if ($stmt->rowCount() > 0) {
                    echo "Update successful<br>";
                }
                else {
                    echo "No record found to update, or values of record were unchanged.";
                }
            }
        }

        header("Location: " .$decoded_url);
        exit;
    }
    catch (Exception $e) {
        die($e->getMessage());
    }
?>
