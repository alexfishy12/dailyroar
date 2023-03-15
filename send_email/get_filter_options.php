<?php 
    
    include("../dbconfig.php");

    $pdo;
    $errorList = [];
    $response = [];

    try {
        $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", "$dbuser", "$dbpass");
    } catch(PDOException $e) {
        array_push($errorList, ("Connection failed: " . $e->getMessage()));
        print_response("", $errorList);
        die();
    }
    
    if ($_SERVER["REQUEST_METHOD"] != "GET") {
        array_push($errorList, "ERROR: Invalid request method.");
        print_response("", $errorList);
        die();
    }

    $response = array(
        "curriculum_dropdown" => generate_dropdown(get_table("Curriculum"), null, "curriculum"),
        "class_standing_dropdown" => generate_dropdown(get_table("ClassStanding"), null, "class_standing")
    );
    print_response($response, $errorList);
    die();
    
    // prints response to webpage
    function print_response($response = [], $errors = []) {
        $string = "";

        // Convert response to JSON string:
        $string = "{\"errors\" : ". json_encode($errors) . ",".
                "\"response\" : ". json_encode($response) ."}";

        echo $string;
    }

    function get_table($table_name) {
        Global $errorList;

        if ($table_name === null) {
            array_push($errorList, "ERROR: Table name is null");
            print_response("", $errorList);
            die();
        }

        if ($table_name != "ActiveProgram" && $table_name != "ClassStanding" && $table_name != "Curriculum") {
            array_push($errorList, "ERROR: Get table $table_name not supported.");
            print_response("", $errorList);
            die();
        }

        //initialize array
        $table_rows = [];

        //get PDO object
        Global $pdo;

        $query = "SELECT * from {$table_name}";
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        if ($stmt->errorCode()==="00000") {
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $arr = array('ID' => $row["ID"], 'name' => null);
                    
                    if ($table_name == "ActiveProgram") {
                        $arr['name'] = $row["ActiveProgram"];
                    }
                    else if ($table_name == "Curriculum") {
                        $arr['name'] = $row["Curriculum"];
                    }
                    else if ($table_name == "ClassStanding") {
                        $arr['name'] = $row["Standing"];
                    }

                    array_push($table_rows, $arr); 
                }
            }
            else {
                array_push($errorList, "Error: No rows found for table $table_name.");
                print_response("", $errorList);
                die();
            }
        }
        else {
            array_push($errorList, $stmt->errorInfo()[2]);
            print_response("", $errorList);
            die();
        }

        return $table_rows;
    }

    function generate_dropdown($choices, $default_choice_id = null, $col_name) {
        Global $errorList;

        if ($choices === null) {
            array_push($errorList, "Error: Invalid choices");
            print_response("", $errorList);
            die();
        }

        $html = "<select name='". $col_name ."' form='email' multiple>";

        foreach ($choices as &$choice){
            if ($choice["ID"] == $default_choice_id && $default_choice_id !== null) {
                $html = $html . "<option class='original_value' value='". $choice["ID"] ."' selected>". $choice["name"] ."</option>";
            }
            else {
                $html = $html . "<option value='". $choice["ID"] ."'>". $choice["name"] ."</option>";
            }
        }
        $html = $html . "</select>";

        return $html;
    }
?>