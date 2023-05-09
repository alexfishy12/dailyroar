<?php 
    include("../dbconfig.php");
    $student_table_col_names = [];
    $error_list = [];
    $successful_deletions = 0;
    $successful_updates = 0;

    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", "$dbuser", "$dbpass");


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!isset($_POST["changed_students"]) || $_POST["changed_students"] === null) {
            echo "ERROR: undefined input data";
            die();
        }

        $student_table_col_names = get_student_table_columns();
        $changed_students = $_POST["changed_students"];
        update_students($changed_students);
        print_response("Successfully made $successful_deletions deletions and $successful_updates updates.", $error_list);
        die();
    }
    else
    {
        echo "ERROR: Invalid request method.";
        die();
    }

    // prints response to webpage
    function print_response($response = "", $errors = []) {
            $string = "";

            // Convert response to JSON string:
            $string = "{\"errors\" : ". json_encode($errors) . ",".
                    "\"response\" : ". json_encode($response) ."}";

            echo $string;
    }

    // executes update or delete statements for each student
    function update_students($changed_students) {
        Global $pdo;
        Global $successful_deletions;
        Global $successful_updates;
        Global $error_list;
        Global $student_table_col_names;

        if (is_array($changed_students) == false) {
            return "ERROR: Invalid student data type entry.";
        }
        if (count($changed_students) < 1) {
            return "ERROR: No student data was sent for updating.";
        }

        // traverse through each student in array and pull changes
        /*  
            At this point, input array should be constructed as such
            $changed_students = [
                {
                    "student_id": int, 
                    "old_values": [
                        {
                            "column_name": string, 
                            "value": (type depends on column)
                        }
                    ], 
                    "new_values": [
                        {
                            "column_name": string, 
                            "value": (type depends on column)
                        }
                    ],
                    "delete": boolean
                }
            ];
        */

        foreach ($changed_students as &$student) {
            $values_to_change = [];
            $query = "";
            $stmt;
            if ($student["delete"] == 'true') {
                $query = "DELETE FROM Students WHERE ID = :student_id;";
                                
                $stmt = $pdo->prepare($query);
            }
            else {
                //start query
                $query = "UPDATE Students SET ";
                
                // check which values were sent to update
                foreach ($student["new_values"] as &$new_value) {
                    $col_name = $new_value["column_name"];
                    $value = $new_value["value"];

                    // check if corresponding column to be edited exists in the student table
                    if (in_array($col_name, $student_table_col_names, true) == false) {
                        continue;

                        //add error to error list in response
                        array_push($error_list, "Invalid column name: $col_name for student with ID: ". $student["ID"]);
                    }
                    else {
                        $query = $query . "$col_name = :$col_name, ";
                        array_push($values_to_change, array("param" => ":".$col_name, "value" => $value));
                    }
                }
                
                //finish setting up query
                $query = rtrim($query, ", ") . " WHERE ID = :student_id;";
                // Prepare the query
                $stmt = $pdo->prepare($query);

                foreach ($values_to_change as &$value) {
                    $stmt->bindParam($value["param"], $value["value"]);
                }
            }
            
            // bind student id parameter
            $stmt->bindParam(":student_id", $student["id"]);
        
            // Execute the query
            $stmt->execute();
        
            // Fetch the result
            if ($stmt->errorCode() === '00000') {
                if ($student["delete"] == 'true') {
                    $successful_deletions++;
                }
                else {
                    $successful_updates++;
                }
            }
            else {
                array_push($error_list, array("query" => $query, "error" => $pdo->errorInfo()[2]));
            }
        }
    }

    function get_student_table_columns() {
        Global $pdo;
        $query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'Students'";
        $stmt = $pdo->prepare($query);

        $stmt->execute();

        if ($stmt->errorCode() === '00000') {
            $col_names = [];
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $col_name = $row["COLUMN_NAME"];
                if ($col_name == "ID") {
                    continue;
                }
                array_push($col_names, $col_name);
            }
            return $col_names;
        }
        else {
            echo $pdo->errorInfo()[2];
            die();
        }
    }   
?>