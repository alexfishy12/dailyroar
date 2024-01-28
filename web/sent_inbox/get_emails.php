<?php 
    session_start();
    include("../dbconfig.php");

    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", "$dbuser", "$dbpass");

    
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        echo "ERROR: Invalid request method.";
        die();
    }
    if (!isset($_POST['semester_id'])){
        echo "ERROR: SemesterID not set";
        die();
    }
    $semester_id = $_POST['semester_id'];

    if ($semester_id == "active") {
        $query = "SELECT ID FROM Semester WHERE IsActive = 1;";
        $stmt = $pdo->prepare($query);
        $stmt->execute();

         // Fetch the result
         if ($stmt->errorCode() !== '00000') {
            echo "ERROR:". $pdo->errorInfo()[2];
            die();
        }
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            echo "ERROR: SemesterID not found.";
            die();
        }
        $semester_id = $row['ID'];
    }

    $result = get_emails($semester_id);
    $result = $result;
    echo $result;
    die();


    function get_emails($semester_id) {
        Global $pdo;

        // Define the query to retrieve the emails
        $query = "SELECT E.ID, DATE_FORMAT(E.Created, '%m/%d/%Y %h:%i %p') as Created, Email_Address as Sender, Subject FROM Email E join Login L on (E.SenderID = L.ID) WHERE SemesterID = :semester_id ORDER BY E.ID DESC;";
        
        // Prepare the query
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":semester_id", $semester_id);
        // Execute the query
        $stmt->execute();
        
        // Fetch the result
        if ($stmt->errorCode() !== '00000') {
            return "ERROR:". $pdo->errorInfo()[2];
            die();
            
        }
        return generate_table($stmt);
    }

    function generate_table($stmt) {
        if ($stmt->rowCount() == 0) {
            return "<b>No emails found.</b>";
        }

        $html = "<table border=1><tr id='header'>" .
                "<th>ID" .
                "<th>Created".
                "<th>Sender" .
                "<th>Subject</tr>";
        
        $count = 0;
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $html = $html . "<tr id='". $row['ID'] ."' tab-index='0'>" .
                "<td>".$row['ID'].
                "<td>".$row['Created'].
                "<td>".$row['Sender'].
                "<td>".$row['Subject']."</tr>";
            $count++;
        }
        $html = $html . "</table>";
        return $html;
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