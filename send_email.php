<?php
    include("dbconfig.php");

    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", "$dbuser", "$dbpassword");
    // $con = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname)
    //     or die("Could not connect to the database.");
    // Create a new PDO connection
    
    function sendEmail($sender, $recipients, $subject, $body, $email_id) {
        global $pdo;

        // Convert the recipients string to an array
        $recipients = explode(',', $recipients);

        // Escape any potentially dangerous characters in the input
        $sender = htmlspecialchars($sender, ENT_QUOTES);
        $subject = htmlspecialchars($subject, ENT_QUOTES);
        $body = htmlspecialchars($body, ENT_QUOTES);

        // Set the email headers
        $headers = "From: $sender\r\n";
        $headers .= "Reply-To: $sender\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        // Send the email to each recipient using the mail() function
        $base_url = "http://obi.kean.edu/~fisheral/capstone/";

        foreach ($recipients as $recipient) {

            // Define the query to retrieve the student ID by email
            $query = "SELECT StudentID FROM Students WHERE EmailAddress = :email";

            // Prepare the query
            $stmt = $pdo->prepare($query);

            // Bind the email parameter
            $stmt->bindParam(":email", $recipient);

            // Execute the query
            $stmt->execute();

            // Fetch the result
            $result = $stmt->fetch();

            // Print the student ID
            $studentID = $result["StudentID"];

            $body = $body. '<img src="'.$base_url.'tracking.php?email_id='.$email_id.'&studentID='.$studentID.'" width="1" height="1" />';
            $recipient = trim($recipient); // Remove any leading/trailing whitespace

            echo "SUCCESS: Email broadcast sent!";
            mail($recipient, $subject, $body, $headers);
            
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $sender = $_POST['composer_address'];
        $recipient = $_POST['recipient_address'];
        $subject = $_POST['subject'];
        $body = $_POST['body'];
        $email_id = $_POST['email_id'];

        if (strlen($recipient) < 1){
            echo "ERROR: There are no students to recieve this email.";
        }
        else {
            sendEmail($sender, $recipient, $subject, $body, $email_id);
        }
    }
?>
