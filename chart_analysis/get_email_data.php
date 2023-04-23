<?php 
    
    include("../dbconfig.php");

    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", "$dbuser", "$dbpass");

    $responseJSON = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (!isset($_POST["email_id"]))
        {
            echo "ERROR: email_id not set.";
            die();
        }
        else if ($_POST["email_id"] == ""){
            echo "ERROR: email_id invalid.";
            die();
        }
        else {
            $email_id = $_POST["email_id"];
            $responseJSON["email_metadata"] = get_email_metadata($email_id);
            $responseJSON["email_data"] = get_email_data($email_id);
            //$responseJSON = json_encode($responseJSON);
            print_response($responseJSON, []);
            die();
        }
    }
    else
    {
        echo "ERROR: Invalid request method.";
        die();
    }

    function get_email_data($email_id) {
        Global $pdo;

        // Define the query to retrieve email data       
        $query = "SELECT EmailID, 
            sum(1) as total_recipients,
            sum(case when Opened = 1 then 1 else 0 end) as total_opened,
            sum(case when Clicked = 1 then 1 else 0 end) as total_clicked
            FROM csemaildb.Tracking where EmailID = :email_id;";

        // Prepare the query
        $stmt = $pdo->prepare($query);
        
        // Bind params
        $stmt->bindParam(":email_id", $email_id);

        // Execute the query
        $stmt->execute();
        
        // Fetch the result
        if ($stmt->errorCode() === '00000') {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result;
        }
        else {
            return "ERROR:". $pdo->errorInfo()[2];
            die();
        }
    }

    function get_email_metadata($email_id) {
        Global $pdo;

        $metadata = [];
        $filters = [];

        // Define the query to retrieve email data       
        $query = "SELECT E.ID as ID, E.Created as Created, L.Email_Address as Sender, Subject, Body from Email E join Login L on (E.SenderID = L.ID) where E.ID = :email_id;";

        // Prepare the query
        $stmt = $pdo->prepare($query);
        
        // Bind params
        $stmt->bindParam(":email_id", $email_id);

        // Execute the query
        $stmt->execute();
        
        // Fetch the result
        if ($stmt->errorCode() === '00000') {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $result["Body"] = htmlspecialchars_decode($result["Body"]);
            $metadata["email"] = $result;
        }
        else {
            return "ERROR:". $pdo->errorInfo()[2];
            die();
        }

        // Define the query to retrieve curriculum filter data       
        $query = "SELECT C.Curriculum from EmailCurriculum EC join Curriculum C on (EC.CurriculumID = C.ID) where EC.EmailID = :email_id;";

        // Prepare the query
        $stmt = $pdo->prepare($query);
        
        // Bind params
        $stmt->bindParam(":email_id", $email_id);

        // Execute the query
        $stmt->execute();
        
        // Fetch the result
        if ($stmt->errorCode() === '00000') {
            $result = $stmt->fetchall();
            $filters["curriculum"] = $result;
        }
        else {
            return "ERROR:". $pdo->errorInfo()[2];
            die();
        }

        // Define the query to retrieve class standing filter data       
        $query = "SELECT C.Standing from EmailClassStanding ECS join ClassStanding C on (ECS.ClassStandingID = C.ID) where ECS.EmailID = :email_id;";

        // Prepare the query
        $stmt = $pdo->prepare($query);
        
        // Bind params
        $stmt->bindParam(":email_id", $email_id);

        // Execute the query
        $stmt->execute();
        
        // Fetch the result
        if ($stmt->errorCode() === '00000') {
            $result = $stmt->fetchall();
            $filters["class_standing"] = $result;
        }
        else {
            return "ERROR:". $pdo->errorInfo()[2];
            die();
        }

        $metadata['filters'] = $filters;
        return $metadata;
    }

    // prints response to webpage
    function print_response($response = [], $errors = []) {
        $string = "";

        // Convert response to JSON string:
        $string = "{\"errors\": ". json_encode($errors) . ", ".
                "\"response\": ". json_encode($response) ."}";

        echo $string;
    }
?>