<?php 

    include("../dbconfig.php");

    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", "$dbuser", "$dbpass");


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

    
    function generate_dropdown($choices, $default_choice_id = null, $col_name) {
        if ($choices === null) {
            echo "Error: Invalid choices";
            die();
        }

        $html = "<select name='". $col_name ."' form='update_student'>";

        if ($default_choice_id == null) {
            $html = $html . "<option class='original_value' value='null' selected></option>";
        }
        else {
            $html = $html . "<option value='null'></option>";
        }
        foreach ($choices as &$choice){
            if ($choice["ID"] == $default_choice_id && $default_choice_id !== null) {
                $html = $html . "<option class='original_value' value='". $choice["ID"] ."' selected>". $choice["name"] ."</option>";
            }
            else {
                $html = $html . "<option value='". $choice["ID"] ."'>". $choice["name"] ."</option>";
            }
            unset($choice);
        }
        $html = $html . "</select>";

        return $html;
    }

?>