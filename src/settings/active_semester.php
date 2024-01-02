<?php
session_start();
if(!isset($_SESSION['account_type'])){
    header("Location: index.php");
    exit;
}
elseif($_SESSION['account_type']=="GA"){
    header("Location: GA_Home.php");
    exit;
}
$now=time();
if($now > $_SESSION['expire']) {
    session_destroy();
    header("Location: ../index.php");  
}
echo "<title id='title'>Daily Roar - Create User</title>";
include("../dbconfig.php");
?>

<!DOCTYPE html>
<html lang="en" >
    <head>
    <meta charset="UTF-8">
        <link rel="icon" href="../_assets/Keanu_head.svg">
        <link href="../_CSS/font_family.css" rel="stylesheet">
        <link href="https://unpkg.com/nes.css@2.3.0/css/nes.min.css" rel="stylesheet" />
        <link href="../_CSS/background_static.css" rel="stylesheet">
        <link href="../_CSS/content.css" rel="stylesheet">
        <link href="../_CSS/active_semester.css" rel="stylesheet">

        <script src="../_libraries/jquery-3.6.0.min.js"></script>
        <script src="active_semester.js"></script>

        <?php include("../faculty_nav.php");?>

        <style>
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
    </style>
       
</head>



<body class="retro" style="background-color:#0c5eb3;">

<div class="subtitle">
    <p>Change Active Semester</p>
</div>

<div class="scroll">
    <div class="content">
        <div class="nes-container with-title is-centered">

            <div class="forms">

                <div id="active_semester">
                    Active Semester: <span id="active_semester_text"></span><br><br>
                    <div class="select_semester">
                        <span class="label">Change to:</span>
                        <select id="semester" class="select"></select>
                        <button id="save_active" class="nes-btn is-primary">Save</button>
                    </div>

                    <br>
                    <div class="separator">OR</div>
                    <br>
                    
                    <button id="create_new_semester" class="nes-btn is-primary">Create New Semester</button>
                </div>


                <form id="create_semester">
                    <u>Create New Semester</u><br><br>
                    <div class="select_semester">
                        <span class="label">Semester:</span>
                        <select name="semester" id="new_semester" form="create_semester" class="select" required>
                            <option value="" disabled selected></option>
                            <option value="Fall">Fall</option>
                            <option value="Winter">Winter</option>
                            <option value="Spring">Spring</option>
                            <option value="Summer">Summer</option>
                        </select>
                    </div>
                    <br>
                    <div class="select_semester">
                        <span class="label">Year:</span>
                        <select name="year" id="new_year" form="create_semester" class="select" required>
                            <option value="" disabled selected></option>
                        </select>
                    </div>
                    <br>
                    <div class="set_active">
                        <label class="label">
                            <input name="make_active" type="checkbox" class="nes-checkbox is-dark" id="make_active" />
                            <span style="color:#25a0ff">Set as Active</span>
                        </label>
                    </div>
                    <br>
                    <button type="submit" class="nes-btn is-primary">Create</button>
                    <button type="reset" id="cancel" class="nes-btn is-error">Cancel</button>
                </form>
                
            </div>
            
            <div class="response">
                <button type="button" id="go_back" class="nes-btn is-primary">Go Back</button><br><br>
                <div id="errors" style="color:red">
                </div><br>
                <div id="response">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="background_parent">
        <img class='pixel_perfect keanu' src='../_assets/Keanu_Idle_FULLSCREEN.gif'></img>
        <img class='pixel_perfect foreground primary-fg' src='../_assets/Foreground_1.png'></img>
        <img class='pixel_perfect middleground primary-mg' src='../_assets/Middleground_2.png'></img>
        <img class='pixel_perfect background' src='../_assets/Background.png'></img>
    </div>
</body>
</html>