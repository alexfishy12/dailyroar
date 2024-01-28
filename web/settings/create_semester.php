<?php 
    session_start();
    include("../dbconfig.php");
    include("../_functions.php");

    return_json_success("Feature disabled for demo purposes.");

    try {
        $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", "$dbuser", "$dbpass");

        $errorList;

        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            return_json_error("Invalid request method.");
        }

        $make_active = 0;
        if (!isset($_POST['year'])) {
            return_json_error("Year not set.");
        }
        if (!isset($_POST['semester'])) {
            return_json_error("Semester not set.");
        }
        if (isset($_POST['make_active'])) {
            $make_active = 1;
        }

        $year = $_POST['year'];
        $semester = $_POST['semester'];
        
        //check to see if semester already exists
        $query = "SELECT ID from Semester where Year = :year and Semester = :semester;";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":year", $year);
        $stmt->bindParam(":semester", $semester);

        //execute query
        $stmt->execute();

        // Fetch the result
        if ($stmt->errorCode() !== '00000') {
            return_json_error("PDO ERROR:" . $pdo->errorInfo()[2]);
        }
            
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // if semester already exists
        if ($row) {
    
            if ($make_active == 0) {
                return_json_failure("$semester $year already exists.");
            }

            //the following code in this if statement should run if the user wants to make the existing semester active

            //set all semesters to inactive
            mysqli_query($con, "UPDATE Semester set IsActive = 0");

            //set this one to active
            $query = "UPDATE Semester SET IsActive = 1 WHERE ID = :ID;";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":ID", $row['ID']);
            $stmt->execute();

                // Fetch the result
            if ($stmt->errorCode() !== '00000') {
                return_json_error("PDO ERROR: ". $pdo->errorInfo()[2]);
            }
            
            $_SESSION['semester'] = $semester . " " . $year;
            return_json_success("$semester $year is now the active semester!");
        }
        
        
        // if the code reaches here, the semester does not exist already, so insert is good to go
        
        if ($make_active == 1) {
            //set all semesters to inactive
            mysqli_query($con, "UPDATE Semester set IsActive = 0");
        }
        

        $query = "INSERT into Semester values (null, :year, :semester, :make_active);";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":year", $year);
        $stmt->bindParam(":semester", $semester);
        $stmt->bindParam(":make_active", $make_active);
        $stmt->execute();

        // Fetch the result
        if ($stmt->errorCode() !== '00000') {
            return_json_error("PDO ERROR: ". $pdo->errorInfo()[2]);
        }

        //return this if the semester was created and set to active
        if ($make_active == 1) {
            $_SESSION['semester'] = $semester . " " . $year;
            return_json_success("The $semester $year semester has been created and activated!");
        }

        //return this if the semester has been created, but not activated
        return_json_success("The $semester $year semester has been created!");
        
    }
    catch (Exception $e) {
        return_json_error($e->getMessage());
    }
?>