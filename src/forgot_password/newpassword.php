<!DOCTYPE html>
<html lang="en" >
<head>
<title>Reset Password</title>
  <script src= "../_libraries/papaparse.min.js" ></script>
  <script type="text/javascript" src="../_libraries/jquery-3.6.0.min.js"></script>
  <script src="../uploadCSV/uploadCSV.js"></script>
  <script src="checkPasswordMatch.js"></script>
  <link rel="icon" href="../_assets/Keanu_head.svg">
  <link href="../_CSS/font_family.css" rel="stylesheet">
  <link rel="stylesheet" href="../_CSS/background_static.css">
  <link rel="stylesheet" href="../_CSS/content.css">
    <link href="https://unpkg.com/nes.css@2.3.0/css/nes.min.css" rel="stylesheet" />
</head>
<body class="retro" background-image="_assets/Background.png"  background-size="cover" style="background-color:#0c5eb3;">
    
    <div class="subtitle" style="text-align: center">
        <p>Forgot Password?</p>
    </div>
  
<div class="content">
<div class="logout">
                <a href="../index.php">Back To Login</a>
            </div>
<div class="nes-container with-title is-centered">
  <p class="label">Reset Password</p>

    <?php
    include "../dbconfig.php";
        if (isset($_POST['code'])){
            
            $enteredcode=$_POST['code'];
            $sql = "SELECT * FROM PasswordCode WHERE Code = '$enteredcode' ";
            $result = mysqli_query($con, $sql);
            $count = mysqli_num_rows($result);

        
        

            if ($count > 0) {

                $sqltime = "SELECT TIMESTAMPDIFF(SECOND  , DateOfCode, NOW()) AS time_difference
                FROM PasswordCode WHERE Code = $enteredcode";
                $resulttime = mysqli_query($con, $sqltime);
                $row = mysqli_fetch_assoc($resulttime);
                $datediff = $row['time_difference'];

                if ($datediff <= 600) {

                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $ID = $row["ID"];
                    $Email = $row["Email"];
                    $Code = $row["Code"];
                    $DateOfCode = $row["DateOfCode"]; 

                    echo "<form action='setnewpassword.php' method='post' required='required'>";
                    echo "<br>Enter your new password:<br> <input type='password' name='password1' id = 'password1'  required ><br>";
                    echo "<br>Confirm your password:";
                    echo "<br> <input type='password' name='password2' id='password2' required>";
                    echo "<p id = 'passwordMatchMessage'> </p>";
                    echo "<input type='hidden' name='Email' value='$Email'>\n";
                    echo "<input type='hidden' name='Code' value='$Code'>\n";
                    echo "<input type='submit' value='Submit' id = 'submit-button'>";
                    echo "</form>";

                }

                else {
                    echo "This code has expired. Please get a new code.";
                }
            }

            if ($count == 0) {
                echo "This code is not in the database";
            }
    }

    
    

    
    ?>
  
  

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