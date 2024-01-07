<?php
    session_start();
    include("../dbconfig.php");
    include("../_functions.php");

    return_json_success("Feature disabled for demo purposes.");

    try {
        $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", "$dbuser", "$dbpass");

        $errorList;
    
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            return_json_error("ERROR: Invalid request method.");
        }
        if (!isset($_POST['ID'])) { 
            return_json_error("ID not set.");
        }

        $ID = $_POST['ID'];
    
        //Check if SemesterID exists
        $query = "SELECT * from Semester where ID = :ID";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":ID", $ID);
        $stmt->execute();

        // If statement resulted in error, print error and die
        if ($stmt->errorCode() !== '00000') {
            return_json_error("PDO Error:" . $pdo->errorInfo()[2]);
        }

        // if zero rows returned, print error and die
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return_json_error("Semester doesn't exist.");
        }

        // get semester and year values of the requested semester
        $semester = $row['Semester'];
        $year = $row['Year'];

        // Change all other Semesters to inactive
        mysqli_query($con, "UPDATE Semester set IsActive = 0");

        // Update Semester where ID = :ID
        $query = "UPDATE Semester set IsActive = 1 WHERE ID = :ID;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":ID", $ID);
        $stmt->execute();

        // If statement resulted in error, print error and die
        if ($stmt->errorCode() !== '00000') {
            return_json_error("PDO Error:" . $pdo->errorInfo()[2]);
        }

        // if zero rows affected, print error and die
        if ($stmt->rowCount() == 0) {
            return_json_error("No semester was set to active.");
        }
        
        // Successfully activated the semester
        $_SESSION['semester'] = $semester . " " . $year;
        return_json_success("$semester $year is now the active semester!");
        
    }
    catch (Exception $e) {
        return_json_error($e->getMessage());
    }
?>