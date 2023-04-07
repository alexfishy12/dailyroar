<?php
    include("../dbconfig.php");

    $responseList = [];
    $errorList = [];
    $email_id = null;

    session_start();
    if  (!isset($_SESSION["user"])){
        array_push($errorList, "ERROR: Login email not set.");
        print_response($responseList, $errorList);
        die();
    }
    if (!isset($_SESSION["id"])){
        array_push($errorList, "ERROR: Login ID not set.");
        print_response($responseList, $errorList);
        die();
    }
    $sender_id = $_SESSION["id"];
    $sender_email = $_SESSION["user"];

    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", "$dbuser", "$dbpass");
    // $con = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname)
    //     or die("Could not connect to the database.");
    // Create a new PDO connection

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $subject = $_POST['subject'];
        $body = $_POST['body'];
        $curriculum = $_POST['curriculum'];
        $class_standing = $_POST['class_standing'];
        //$attachments = $_POST['attachments'];

        $curriculum = json_decode($curriculum, true);
        $class_standing = json_decode($class_standing, true);

        $recipients = getRecipients($curriculum, $class_standing);
        $email_id = insert_into_email_table($sender_id, $subject, $body, $recipients);
       // insert_into_attachments_table($email_id, $attachments);
        insert_into_emailCurriculum_table($email_id, $curriculum);
        insert_into_emailClassStandings_table($email_id, $class_standing);
        sendEmail($email_id, $sender_id, $sender_email, $recipients, $subject, $body);
        
    }

    //THIS FUNCTION IS UNUSED, WE USE SESSION VARIABLES FOR SENDER INFO
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
        Global $responseList;
        Global $errorList;
        $values_to_search = [];

        // start query
        $query = "SELECT ID, FirstName, LastName, EmailAddress from csemaildb.TestStudents where ";

        //paramCount
        $count = 0;

        
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
                array_push($errorList, "ERROR: No students found using the selected filters.");
                print_response($responseList, $errorList);
                die();
            }
        }
        else {
            array_push($errorList, "ERROR: ". $stmt->errorInfo()[2]);
            print_response($responseList, $errorList);
            die();
        }
    }

    function sendEmail($email_id, $sender_id, $sender_email, $recipients, $subject, $body) {

        //access global variables inside function
        Global $pdo;
        Global $responseList;
        Global $errorList;

        // Set the email headers
        $headers = "From: ". $sender_email. "\r\n";
        $headers .= "Reply-To: ". $sender_email. "\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        //set baseURL for tracking link
        $base_url = "http://obi.kean.edu/~fisheral/dailyroar/";
        
        // Send the email to each recipient using the mail() function
        foreach ($recipients as $recipient) {
            insert_into_tracking_table($email_id, $recipient['ID']);
            
            //attach tracking link
            $new_body = $body. '<img src="'.$base_url.'tracking.php?email_id='. $email_id .'&student_id='.$recipient["ID"].'" width="1" height="1" />';
           
            //send the actual email 
            // (the @ symbol suppresses warnings produced by the function)
            // in this case, I am using '@' to supress the mail function's warning about failing to connect to mail server
            $email = @mail($recipient["Email"], $subject, $new_body, $headers);
            if ($email) {
                array_push($responseList, "Email sent to ". $recipient["Email"] ." successfully.");
            } else {
                array_push($errorList, "An error occurred while sending the email to ". $recipient["Email"] . ".");
            }
        }
    }

    //inserts email into db, returns email's ID in the db
    function insert_into_email_table($sender_id, $subject, $body, $recipients) {
        Global $pdo;
        Global $responseList;
        Global $errorList;

        $recipient_count = 0;
        foreach ($recipients as &$recipient) {
            $recipient_count++;
        }

        // Escape any potentially dangerous characters in the input
        $sqlsubject = htmlspecialchars($subject, ENT_QUOTES);
        $sqlbody = htmlspecialchars($body, ENT_QUOTES);

        //insert email into email table
        $query = "insert into Email values(null, CURRENT_TIMESTAMP(), :sender_id, :subject, :body, 0, 0, :recipient_count);";

        $stmt = $pdo->prepare($query);

        //bind params
        $stmt->bindParam(":sender_id", $sender_id);
        $stmt->bindParam(":subject", $sqlsubject);
        $stmt->bindParam(":body", $sqlbody);
        $stmt->bindParam(":recipient_count", $recipient_count);

        $stmt->execute();

        if ($stmt->errorCode()==="00000") {
            $email_id = $pdo->lastInsertId();
            return $email_id;
        }
        else {
            array_push($errorList, $stmt->errorInfo()[2]);
            print_response($responseList, $errorList);
            die();
        }
    }

    function insert_into_tracking_table($email_id, $recipient_id) {
        Global $pdo;
        Global $responseList;
        Global $errorList;

         //insert statement for this student tracking response to this email
         $tracking_query = "INSERT into Tracking(StudentID, EmailID, Opened, Clicked) values (:student_id, :email_id, 0, 0)";
         $stmt = $pdo->prepare($tracking_query);
         $stmt->bindParam(":student_id", $recipient_id);
         $stmt->bindParam(":email_id", $email_id);
         $tracking_insert_result = $stmt->execute();
         
         //checks if tracking for this email and student was inserted
         if ($tracking_insert_result) {
             //echo "SUCCESS: Insert into tracking table success.<br>";
         }
         else {
             array_push($errorList, "Insert into tracking table failed for StudentID: ". $recipient_id . " and EmailID: ". $email_id . ". Email not sent.");
         }
    }

    function insert_into_attachments_table($email_id, $attachments) {
        Global $pdo;
        Global $responseList;
        Global $errorList;
        $values_to_insert = [];

        $count = 0;
        //go through each attachment, save it to the server, and create parameters to save it 
        $attachments_param = "(";
        foreach ($attachments as &$file) {

            //save file to server
            $file_path = save_attachment($file);

            // email_id parameter for insert
            $paramName = ":param".$count;
            $curriculum_param = $curriculum_param . $paramName .", ";
            array_push($values_to_insert, array("param" => $paramName, "value" => $email_id));
            $count++;

            // attachment file path for insert
            $paramName = ":param".$count;
            $curriculum_param = $curriculum_param . $paramName . "), (";
            array_push($values_to_insert, array("param" => $paramName, "value" => $file["path"]));
            $count++;
        }
        
        $curriculum_param = rtrim($curriculum_param, ", (") . ";";
        
        //insert statement for class standings
        $query = "INSERT into EmailAttachments values " . $curriculum_param;
        $stmt = $pdo->prepare($query);
        
        foreach ($values_to_insert as &$value) {
            $stmt->bindParam($value["param"], $value["value"]);
        }

        //execute query
        $stmt->execute();
        
        if ($stmt->errorCode() === '00000') {
            //success
        }
        else {
            array_push($errorList, $pdo->errorInfo()[2]);
            print_response([], $errorList);
            die();
        }
    }

    function insert_into_emailCurriculum_table($email_id, $curriculum) {
        Global $pdo;
        Global $responseList;
        Global $errorList;
        $values_to_insert = [];

        $count = 0;
        //create parameters for class standings
        $curriculum_param = "(";
        foreach ($curriculum as &$program_ID) {
            // email_id parameter for insert
            $paramName = ":param".$count;
            $curriculum_param = $curriculum_param . $paramName .", ";
            array_push($values_to_insert, array("param" => $paramName, "value" => $email_id));
            $count++;

            // curriculum_id parameter for insert
            $paramName = ":param".$count;
            $curriculum_param = $curriculum_param . $paramName . "), (";
            array_push($values_to_insert, array("param" => $paramName, "value" => $program_ID));
            $count++;
        }
        
        $curriculum_param = rtrim($curriculum_param, ", (") . ";";
        
        //insert statement for class standings
        $query = "INSERT into EmailCurriculum values " . $curriculum_param;
        $stmt = $pdo->prepare($query);
        
        foreach ($values_to_insert as &$value) {
            $stmt->bindParam($value["param"], $value["value"]);
        }

        //execute query
        $stmt->execute();
        
        if ($stmt->errorCode() === '00000') {
            //success
        }
        else {
            array_push($errorList, $pdo->errorInfo()[2]);
            print_response([], $errorList);
            die();
        }
    }

    function insert_into_emailClassStandings_table($email_id, $class_standing) {
        Global $pdo;
        Global $responseList;
        Global $errorList;
        $values_to_insert = [];

        $count = 0;
        //create parameters for class standings
        $class_standing_param = "(";
        foreach ($class_standing as &$level_ID) {
            // email_id parameter for insert
            $paramName = ":param".$count;
            $class_standing_param = $class_standing_param . $paramName .", ";
            array_push($values_to_insert, array("param" => $paramName, "value" => $email_id));
            $count++;

            // class_standing_id parameter for insert
            $paramName = ":param".$count;
            $class_standing_param = $class_standing_param . $paramName . "), (";
            array_push($values_to_insert, array("param" => $paramName, "value" => $level_ID));
            $count++;
        }
        
        $class_standing_param = rtrim($class_standing_param, ", (") . ";";
        
        //insert statement for class standings
        $query = "INSERT into EmailClassStanding values " . $class_standing_param;
        $stmt = $pdo->prepare($query);
        
        foreach ($values_to_insert as &$value) {
            $stmt->bindParam($value["param"], $value["value"]);
        }

        //execute query
        $stmt->execute();
        
        if ($stmt->errorCode() === '00000') {
            //success
        }
        else {
            array_push($errorList, $pdo->errorInfo()[2]);
            print_response([], $errorList);
            die();
        }
    }


    //saves attachment to server, returns file path of where it was saved
    function save_attachment($file) {
        Global $errorList;

        $name = $file['name'];
        $target_dir = "../upload/";
        $target_file = $target_dir . basename($name);
    
        // Select file type
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
        // Valid file extensions
        $extensions_arr = array("jpg","jpeg","png","gif");
        
        // Check extension
        if( in_array($imageFileType,$extensions_arr) ){
            // Upload file
            $file_uploaded = move_uploaded_file($file["tmp_name"], $target_dir);
            if($file_uploaded){
                //Return file path
                return $target_file;
            }
            else {
                array_push($errorList, "Error: File not uploaded");
                print_response([], $errorList);
                die();
            }
        }
        else {
            array_push($errorList, "Error: File type not accepted for file: " . $file['name']);
            print_response([], $errorList);
            die();
        }
    }

    print_response($responseList, $errorList);

    // prints response to webpage
    function print_response($response = [], $errors = []) {
        $string = "";

        // Convert response to JSON string:
        $string = "{\"errors\" : ". json_encode($errors) . ",".
                "\"response\" : ". json_encode($response) ."}";

        echo $string;
    }
?>