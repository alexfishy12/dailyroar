<?php 

    include("../dbconfig.php");

    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", "$dbuser", "$dbpass");

    $errorList;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $make_active = 0;
        if (!isset($_POST['year'])) {
            print_response("", ["Year not set."]);
            die();
        }
        if (!isset($_POST['semester'])) {
            print_response("", ["Semester not set."]);
            die();
        }
        if (isset($_POST['make_active'])) {
            $make_active = 1;
        }
        $year = $_POST['year'];
        $semester = $_POST['semester'];
        $result = create_semester($year, $semester, $make_active);
        print_response($result, []);
        die();
    }
    else
    {
        array_push($errorList, "ERROR: Invalid request method.");
        print_response("", $errorList);
        die();
    }

    function create_semester($year, $semester, $make_active){
        Global $pdo;
        Global $con;

        //check to see if semester already exists
        $query = "SELECT ID from Semester where Year = :year and Semester = :semester;";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":year", $year);
        $stmt->bindParam(":semester", $semester);

        //execute query
        $stmt->execute();

        // Fetch the result
        if ($stmt->errorCode() !== '00000') {
            array_push($error_list, array("query" => $query, "error" => $pdo->errorInfo()[2]));
            print_response("", $error_list);
            die();
        }
            
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // if semester already exists
        if ($row) {
    
            if ($make_active == 0) {
                print_response("", ["$semester $year already exists."]);
                die();
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
                array_push($error_list, array("query" => $query, "error" => $pdo->errorInfo()[2]));
                print_response("", $error_list);
                die();
            }
            
            print_response("$semester $year is now the active semester!", ["$semester $year already exists!"]);
            die();
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
            array_push($error_list, array("query" => $query, "error" => $pdo->errorInfo()[2]));
            print_response("", $error_list);
            die();
        }

        //return this if the semester was created and set to active
        if ($make_active == 1) {
            return "The $semester $year semester has been created and activated!";
        }

        //return this if the semester has been created, but not activated
        return "The $semester $year semester has been created!";
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