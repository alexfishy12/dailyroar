<?php 
    
    include("../dbconfig.php");

    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", "$dbuser", "$dbpass");

    
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $result = get_emails();
        $result = $result;
        echo $result;
        die();
    }
    else
    {
        echo "ERROR: Invalid request method.";
        die();
    }

    function get_emails() {
        Global $pdo;

        // Define the query to retrieve the emails
        
        $query = "SELECT E.ID, Created, Email_Address as Sender, Subject FROM csemaildb.Email E join csemaildb.Login L on (E.SenderID = L.ID);";
        
        // Prepare the query
        $stmt = $pdo->prepare($query);
        
        // Execute the query
        $stmt->execute();
        
        // Fetch the result
        if ($stmt->errorCode() === '00000') {
            return generate_table($stmt);
        }
        else {
            return "ERROR:". $pdo->errorInfo()[2];
            die();
        }
    }

    function generate_table($stmt) {
        if ($stmt->rowCount() > 0) {
            $html = "<table border=1><tr id='header'>" .
                    "<th>ID" .
                    "<th>Created".
                    "<th>Sender" .
                    "<th>Subject</tr>";
            
            $count = 0;
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $html = $html . "<tr id='". $row['ID'] ."'>" .
                    "<td>".$row['ID'].
                    "<td>".$row['Created'].
                    "<td>".$row['Sender'].
                    "<td>".$row['Subject']."</tr>";
                $count++;
            }
            $html = $html . "</table>";
            return $html;
        }
        else {
            return "<b>ERROR: No emails found.</b>";
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