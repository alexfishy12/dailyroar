<?php
    include("../dbconfig.php");


    session_start();
    if  (!isset($_SESSION["user"])){
        echo "ERROR: Login email not set.";
        die();
    }
    if (!isset($_SESSION["id"])){
        echo "ERROR: Login ID not set.";
        die();
    }
    $sender_email = $_SESSION["user"];
    $sender_id = $_SESSION["id"];

    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", "$dbuser", "$dbpass");
    // $con = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname)
    //     or die("Could not connect to the database.");
    // Create a new PDO connection

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $subject = $_POST['subject'];
        $body = $_POST['body'];
        $curriculum = $_POST['curriculum'];
        $class_standing = $_POST['class_standing'];

        $recipients = getRecipients($curriculum, $class_standing);
        sendEmail($recipients, $subject, $body);
        
    }

    function getSender($sender_id){
        Global $pdo;
        $sender;
        $query = "SELECT ID, Email_Address from Login where ID = :sender_id;";

        $stmt = $pdo->prepare($query);

        $stmt->execute();
        
        if ($stmt->errorCode()==="00000") {
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $sender = array('ID' => $row["ID"], 'Email' => $row['EmailAddress']);
                }
                return $sender;
            }
            else {
                echo "No sender found with the query: <br>".$query;
                die();
            }
        }
        else {
            echo "ERROR: ". $stmt->errorInfo()[2];
            die();
        }
    }

    function getRecipients($curriculum, $class_standing) {
        Global $pdo;
        $values_to_search = [];

        // start query
        $query = "SELECT ID, FirstName, LastName, EmailAddress from csemaildb.TestStudents where ";

        //paramCount
        $count = 0;

        $curriculum = json_decode($curriculum, true);
        //create parameters for curriculum (major1)
        $curriculum_param = "(";
        foreach ($curriculum as &$programID) {
            $paramName = ":param".$count;
            $curriculum_param = $curriculum_param . $paramName .", ";
            array_push($values_to_search, array("param" => $paramName, "value" => $programID));
            $count = $count + 1;
        }
        $curriculum_param = rtrim($curriculum_param, ", ") . ")";

        //create parameters for curriculum (major2)
        $curriculum_param2 = "(";
        foreach ($curriculum as &$programID) {
            $paramName = ":param".$count;
            $curriculum_param2 = $curriculum_param2 . $paramName .", ";
            array_push($values_to_search, array("param" => $paramName, "value" => $programID));
            $count = $count + 1;
        }
        $curriculum_param2 = rtrim($curriculum_param2, ", ") . ")";

        //create parameters for curriculum (minor)
        $curriculum_param3 = "(";
        foreach ($curriculum as &$programID) {
            $paramName = ":param".$count;
            $curriculum_param3 = $curriculum_param3 . $paramName .", ";
            array_push($values_to_search, array("param" => $paramName, "value" => $programID));
            $count = $count + 1;
        }
        $curriculum_param3 = rtrim($curriculum_param3, ", ") . ")";

        $class_standing = json_decode($class_standing, true);
        //create parameters for class standings
        $class_standing_param = "(";
        foreach ($class_standing as &$levelID) {
            $paramName = ":param".$count;
            $class_standing_param = $class_standing_param . $paramName .", ";
            array_push($values_to_search, array("param" => $paramName, "value" => $levelID));
            $count = $count + 1;
        }
        $class_standing_param = rtrim($class_standing_param, ", ") . ")";

        $query = $query . "(Major1 IN ". $curriculum_param
                        . " OR Major2 IN ". $curriculum_param2
                        . " OR Minor IN ". $curriculum_param3 . ")"
                        . " AND (ClassStanding IN ". $class_standing_param . ");";

        // Prepare the query
        $stmt = $pdo->prepare($query);

        foreach ($values_to_search as &$value) {
            $stmt->bindParam($value["param"], $value["value"]);
        }
    
        $stmt->execute();

        if ($stmt->errorCode()==="00000") {
            if ($stmt->rowCount() > 0) {
                $students = [];
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    array_push($students, array('ID' => $row["ID"], "FirstName" => $row["FirstName"], "LastName" => $row["LastName"], 'Email' => $row['EmailAddress']));
                }
                return $students;
            }
            else {
                echo "No students found with the query: <br>".$query;
                die();
            }
        }
        else {
            echo "ERROR: ". $stmt->errorInfo()[2];
            die();
        }
    }

    function sendEmail($recipients, $subject, $body) {
        Global $pdo;
        Global $sender_id;
        Global $sender_email;
        $email_id;

        // Escape any potentially dangerous characters in the input
        $subject = htmlspecialchars($subject, ENT_QUOTES);
        $body = htmlspecialchars($body, ENT_QUOTES);

        // Set the email headers
        $headers = "From: ". $sender_email. "\r\n";
        $headers .= "Reply-To: ". $sender_email. "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        //insert email into email table
        $query = "insert into Email values(null, CURRENT_TIMESTAMP(), :sender_id, :subject, :body, :attachments, 0, 0, 0);";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":sender_id", $sender_id);
        $stmt->bindParam(":subject", $subject);
        $stmt->bindParam(":body", $body);
        $attachments = "";
        $stmt->bindParam(":attachments", $attachments);

        $stmt->execute();

        if ($stmt->errorCode()==="00000") {
            $email_id = $pdo->lastInsertId();
        }
        else {
            echo "ERROR: ". $stmt->errorInfo()[2];
            die();
        }

        // Send the email to each recipient using the mail() function
        $base_url = "http://obi.kean.edu/~fisheral/capstone/";

        foreach ($recipients as $recipient) {            
            echo $recipient["ID"];
            echo $email_id;
            $body = $body. '<img src="'.$base_url.'tracking.php?email_id='. $email_id .'&student_id='.$recipient["ID"].'" width="1" height="1" />';
            
            //insert statement for this student tracking response to this email
            $tracking_query = "INSERT into Tracking(StudentID, EmailID, Opened, Clicked) values (:student_id, :email_id, 0, 0)";
            $stmt = $pdo->prepare($tracking_query);
            $stmt->bindParam(":student_id", $recipient["ID"]);
            $stmt->bindParam(":email_id", $email_id);
            $tracking_insert_result = $stmt->execute();
            
            //checks if tracking for this email and student was inserted
            if ($tracking_insert_result) {
                echo "SUCCESS: Insert into tracking table success.";
                echo "<br>";
            }
            else {
                echo "ERROR: Insert into tracking table failed!";
                echo "<br>";
            }
            
            $email = mail($recipient["Email"], $subject, $body, $headers);
            if ($email) {
                echo 'SUCCESS: Email sent successfully.';
            } else {
                echo 'ERROR: An error occurred while sending the email.';
            }
        }
    }
?>
