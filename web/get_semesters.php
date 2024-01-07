<?php 

    include("dbconfig.php");
    include("_functions.php");

    try {
        $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", "$dbuser", "$dbpass");
        $errorList;
    
        if ($_SERVER["REQUEST_METHOD"] != "POST") {
            return_json_error("Invalid request method.");
        }

        $query = "SELECT * from Semester order by Year Asc;";

        $stmt = $pdo->prepare($query);

        //execute query
        $stmt->execute();

        // Fetch the result
        if ($stmt->errorCode() !== '00000') {
            return_json_error($pdo->errorInfo()[2]);
        }

        $semesters = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            array_push($semesters, $row);
        }
        return_json_success($semesters);
        
    }
    catch (Exception $e) {
        return_json_error($e->getMessage());
    }
?>