<?php
session_start();
if(!isset($_SESSION['account_type'])){
    header("Location: ../index.php");
	exit;
}
elseif(isset($_SESSION['account_type']) && $_SESSION['account_type']=="GA"){
    header("Location: ../GA_Home.php");
    exit;
}
$now=time();
if($now > $_SESSION['expire']) {
    session_destroy();
    header("Location: ../index.php");  
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="../libraries/jquery-3.6.0.min.js"></script>
    <script src="update_student.js"></script>
    <link href="../CSS/font_family.css" rel="stylesheet">
    <link href="../CSS/content.css" rel="stylesheet">
    <link href="../CSS/background_static.css" rel="stylesheet">
    <link href="https://unpkg.com/nes.css@2.3.0/css/nes.min.css" rel="stylesheet" />
    
 
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Roar - Update Students</title>
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
<?php 
include("../faculty_nav.php"); 
?>
    <body class='retro' style="background-color:#0c5eb3;">
    
    <div class="title">
        Update Student Data
    </div>
    
    <div class="scroll">
        <div class="content">
                <div class="nes-container with-title is-centered" style="background:rgba(0,0,0,0.5)">
                    <form id="search">
                        <label for="student_name">Search for student by first name, last name, or email address: </label>
                        <input type="text" name="student_name" id="search_box" form="search">
                        <button type="submit" name="search_student" id="search_button" form="search">Search</button>
                    </form>
                    <br>
                    <div id="info"></div>
                    <div id="students_table" class="students_table"></div>
                    <div class="error" id="students_table_error"></div>
                    <br>
                    <div id="form_options">
                        <button id="done" disabled>Done</button><br>
                        <button id="cancel" onclick="location.reload()">Cancel Edits and Refresh Page</button>
                    </div>
                    <div id="review_options">
                        <button id="confirm">Confirm</button><br>
                        <button id="make_changes">Make changes</button>
                    </div>
                    <div id="finished_options">
                        <button id="refresh" onclick="location.reload()">Update more students</button><br>
                        <button id="home" onclick="window.location.href = '../Faculty_Home.php'">Home</button>
                    </div>
                    <div id="update_response"></div>
                </div>
        </div>
    </div>


    <div class="background_parent">
        <img class='pixel_perfect keanu' src='../assets/Keanu_Idle_FULLSCREEN.gif'></img>
        <img class='pixel_perfect foreground primary-fg' src='../assets/Foreground_1.png'></img>
        <img class='pixel_perfect middleground primary-mg' src='../assets/Middleground_2.png'></img>
        <img class='pixel_perfect background' src='../assets/Background.png'></img>
    </div>
    </body>
</html>

