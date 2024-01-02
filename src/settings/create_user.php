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
        <script src="../forgot_password/checkPasswordMatch.js"></script>
        <?php include("../faculty_nav.php");?>
</head>

<body class="retro" style="background-color:#0c5eb3;">

<div class="subtitle">
    <p>Create New User</p>
</div>

<div class="scroll">
    <div class="content">
        <div class="nes-container with-title is-centered">
            <form name = "input" action="insert_user.php" method="post">
                <div class="nes-field is-inline">
                    <label for="inline-field"> First Name: </label>
                    <input type="text" id="inline_field" class="nes-input is-success" name="f_name" required>
                </div>
                <br>
                <div class="nes-field is-inline">
                    <label for="inline-field"> Last Name: </label>
                    <input type="text" id="inline_field" class="nes-input is-success" name="l_name" required>
                </div>
                <br>
                <hr>
               <div class="nes-select">
                    <label for="inline-field"> Account Type: (Select one)</label>
                        <br>
                    <label>
                        <input type="radio" class="nes-radio" name="acc_type" value="FA" checked required/>
                        <span>Faculty</span>
                    </label>

                    <label>
                        <input type="radio" class="nes-radio" name="acc_type" value ="GA" required/>
                        <span>Graduate Assistant</span>
                    </label>
               </div>
               <hr>
               <br>
               <div class="nes-field is-inline">
                    <label for="inline-field"> Email Address: </label>
                    <input type="email" id="inline_field" class="nes-input is-success" name="email" required>
                </div>
                <br>
               <div class="nes-field is-inline">
                    <label for="inline-field">Password:</label>
                    <input type="password" id="password1" class="nes-input is-success" name="password1" required>
                </div>
                <br>
                <div class="nes-field is-inline">
                    <label for="inline-field">Confirm Password:</label>
                    <input type="password" id="password2" class="nes-input is-success" name="password2" required>
                </div>
                <br>
				<br>
                <p id = 'passwordMatchMessage'> </p>
					<input class="nes-btn is-primary" type="submit" value="Submit" id ="submit-button">

				<br>
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