<?php
session_start();
if(!isset($_SESSION['account_type'])){
    header("Location: index.php");
	exit;
}
elseif(isset($_SESSION['account_type']) && $_SESSION['account_type']=="GA"){
    header("Location: GA_Home.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="../libraries/jquery-3.6.0.min.js"></script>
    <script src="update_student.js"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student</title>
    <style>
        .students_table {
            max-height:50vh;
            max-width:80vw;
            overflow: scroll;
        }
        .error {
            color: #ff0000;
            font-weight: bold;
        }
        .original_value {
            background-color:aquamarine;
        }
        .new_value {
            background-color:yellow;
        }
        option:checked {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <a href="../Faculty_Home.php">Go Home (Cancels changes)</a><br><br>
    Search for student by name: <input type="text" name="student_name" id="search_box">
    <button name="search_student" id="search">Search</button><br>
    <div id="info" hidden></div>
    <div id="students_table" class="students_table" hidden></div>
    <div class="error" id="students_table_error"></div>
    <br>
    <div id="form_options" hidden>
        <button id="done" disabled>Done</button>
    </div>
    <div id="review_options" hidden>
        <button id="confirm">Confirm</button>
    </div>
    <div id="update_response"></div>
</body>
</html>