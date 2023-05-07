<?php 
    
    include("../dbconfig.php");

    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", "$dbuser", "$dbpass");

    
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
            $result = get_email_data($email_id);
            $result = $result;
            print_response($result, []);
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
            FROM Tracking where EmailID = :email_id;";

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

    // prints response to webpage
    function print_response($response = "", $errors = []) {
        $string = "";

        // Convert response to JSON string:
        $string = "{\"errors\" : ". json_encode($errors) . ",".
                "\"response\" : ". json_encode($response) ."}";

        echo $string;
    }
?>