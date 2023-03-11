<?php 
include("../dbconfig.php");

    $pdo = new PDO("mysql:host=$host;dbname=$dbname", "$username", "$password");

    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!isset($_POST["search_text"]) || $_POST["search_text"] === null) {
            echo "ERROR: undefined input data";
            die();
        }
        $search_text = $_POST["search_text"];
        $result = get_students($search_text);
        $result = $result;
        echo $result;
        die();
    }
    else
    {
        echo "ERROR: Invalid request method.";
        die();
    }

    function get_students($search_text) {
        Global $pdo;
        // Define the query to retrieve the students
        $query = "";
        if ($search_text == "" || $search_text == null) {
            $query = "SELECT * FROM csemaildb.Students;";
        }
        else {
            $search_text = "%" . $search_text . "%";
            $query = "SELECT * from Students where (FirstName like :first_name) OR (LastName like :last_name) OR (EmailAddress like :email)";
        }
        // Prepare the query
        $stmt = $pdo->prepare($query);
        
        // Bind the search parameters
        //$stmt->bindParam(":name", $search_text);
        if ($search_text != "" && $search_text != null) {
            $stmt->bindParam(":first_name", $search_text, PDO::PARAM_STR);
            $stmt->bindParam(":last_name", $search_text, PDO::PARAM_STR);
            $stmt->bindParam(":email", $search_text, PDO::PARAM_STR);
        }
        
        // Execute the query
        $stmt->execute();
        
        // Fetch the result
        if ($stmt->errorCode() === '00000') {
            return generate_table($stmt);
        }
        else {
            return $pdo->errorInfo()[2];
            die();
        }
    }

    function generate_table($stmt) {
        if ($stmt->rowCount() > 0) {
            $active_programs = get_table("ActiveProgram");
            $curricula       = get_table("Curriculum");
            $class_standings = get_table("ClassStanding");

            $html = "<table border=1><tr id='header'>" .
                    "<th>ID" .
                    "<th>First Name" .
                    "<th>Last Name" .
                    "<th>Active Program" .
                    "<th>Major 1" .
                    "<th>Major 2" .
                    "<th>Minor" .
                    "<th>Class Standing" .
                    "<th>Email Address".
                    "<th>Delete?";
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $html = $html . "<tr id='". $row['ID'] ."'>" .
                    "<td>".$row['ID'].
                    "<td><input type='text' name='FirstName' value='".$row['FirstName']. "'>".
                    "<td><input type='text' name='LastName' value='".$row['LastName']. "'>".
                    "<td>".generate_dropdown($active_programs, $row['ActiveProgram'], "ActiveProgram").
                    "<td>".generate_dropdown($curricula, $row['Major1'], "Major1").
                    "<td>".generate_dropdown($curricula, $row['Major2'], "Major2").
                    "<td>".generate_dropdown($curricula, $row['Minor'], "Minor").
                    "<td>".generate_dropdown($class_standings, $row['ClassStanding'], "ClassStanding").
                    "<td><input type='text' name='EmailAddress' value='".$row['EmailAddress'] . "'>".
                    "<td><input type='checkbox' name='Delete'>";
            }
            $html = $html . "</table>";
            return $html;
        }
        else {
            return "<b>ERROR: No students found.</b>";
        }
    }

    // Returns array of objects, each object containing one row from the table
    function get_table($table_name) {
        if ($table_name === null) {
            echo "ERROR: Table name is null";
            die();
        }

        if ($table_name != "ActiveProgram" && $table_name != "ClassStanding" && $table_name != "Curriculum") {
            echo "ERROR: Get table $table_name not supported.";
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
                return "Error: No rows found for table $table_name.";
            }
        }
        else {
            echo $stmt->errorInfo()[2];
            die();
        }

        return $table_rows;
    }

    /* Returns HTML select dropdown list,
        Takes:
            $choices = array of objects of structure [{id: int, <name>: String}, ...]
            $default = ID of default choice. If no input, $default == null
    */
    function generate_dropdown($choices, $default_choice_id = null, $col_name) {
        if ($choices === null) {
            echo "Error: Invalid choices";
            die();
        }

        $html = "<select name='". $col_name ."' form='update_student'>";

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