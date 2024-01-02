<?php
    session_start();
    include("../dbconfig.php");

    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", "$dbuser", "$dbpass");

    $errorList;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!isset($_POST['ID'])) { 
            print_response("", ["ID not set."]);
            die();
        }
        $ID = $_POST['ID'];
        $result = set_active_semester($ID);
        print_response($result, []);
        die();
    }
    else
    {
        array_push($errorList, "ERROR: Invalid request method.");
        print_response("", $errorList);
        die();
    }

    function set_active_semester($ID){
        Global $pdo;
        Global $con;

        //Check if SemesterID exists
        $query = "SELECT * from Semester where ID = :ID";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":ID", $ID);
        $stmt->execute();

        // If statement resulted in error, print error and die
        if ($stmt->errorCode() !== '00000') {
            array_push($error_list, array("query" => $query, "error" => $pdo->errorInfo()[2]));
            print_response("", $error_list);
            die();
        }

         // if zero rows returned, print error and die
         $row = $stmt->fetch(PDO::FETCH_ASSOC);
         if (!$row) {
            print_response("", ["Semester doesn't exist."]);
            die();
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
            array_push($error_list, array("query" => $query, "error" => $pdo->errorInfo()[2]));
            print_response("", $error_list);
            die();
        }

        // if zero rows affected, print error and die
        if ($stmt->rowCount() == 0) {
            print_response("", ["No semester was set to active."]);
            die();
        }
        
        // Successfully activated the semester
        $_SESSION['semester'] = $semester . " " . $year;
        return "$semester $year is now the active semester!";
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