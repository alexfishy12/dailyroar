<?php 

    include("../dbconfig.php");

    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", "$dbuser", "$dbpass");

    $errorList;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $result = get_semesters();
        print_response($result, []);
        die();
    }
    else
    {
        array_push($errorList, "ERROR: Invalid request method.");
        print_response("", $errorList);
        die();
    }

    function get_semesters(){
        Global $pdo;

        $query = "SELECT * from Semester order by Year Asc;";

        $stmt = $pdo->prepare($query);

        //execute query
        $stmt->execute();

         // Fetch the result
         if ($stmt->errorCode() === '00000') {
            $semesters = [];
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($semesters, $row);
            }
            return $semesters;
         }
         else {
             array_push($error_list, array("query" => $query, "error" => $pdo->errorInfo()[2]));
             print_response("", $error_list);
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