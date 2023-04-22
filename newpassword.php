<!DOCTYPE html>
<html lang="en" >
<head>
<title>Reset Password</title>
  <script src= "libraries/papaparse.min.js" ></script>
  <script type="text/javascript" src="libraries/jquery-3.6.0.min.js"></script>
  <script src="uploadCSV/uploadCSV.js"></script>
  <script src="checkPasswordMatch.js"></script>
  <link href="CSS/font_family.css" rel="stylesheet">
  <link href="CSS/faculty_home_page.css" rel="stylesheet">
<link href="https://unpkg.com/nes.css@2.3.0/css/nes.min.css" rel="stylesheet" />
</head>
<body class="retro" style="margin-top:10vh; margin-bottom:30vh; margin-left:20vw; margin-right:20vw;">
    
    <div class="body" style="text-align: center">
        <p>Welcome to the Daily Roar!</p>
    </div>
  

<div class="nes-container with-title is-centered">
  <p class="title">Reset Password</p>

    <?php
    include "dbconfig.php";
        if (isset($_POST['code'])){
            
            $enteredcode=$_POST['code'];
            $sql = "SELECT * FROM csemaildb.PasswordCode WHERE Code = '$enteredcode' ";
            $result = mysqli_query($con, $sql);
            $count = mysqli_num_rows($result);

            if ($count > 0) {

            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $ID = $row["ID"];
            $Email = $row["Email"];
            $Code = $row["Code"];
            $DateOfCode = $row["DateOfCode"]; 

            



            echo "<form action='setnewpassword.php' method='post' required='required'>";
            echo "<br>Enter your new password: <input type='password' name='password1' id = 'password1'  required ><br>";
            echo "<br>Confirm your password: <br> <input type='password' name='password2' id='password2' required>";
            echo "<p id = 'passwordMatchMessage'> </p>";
            echo "<input type='hidden' name='Email' value='$Email'>\n";
            echo "<input type='submit' value='Submit' id = 'submit-button'>";
            echo "</form>";

            echo "<br>" .$ID."";
            echo "<br>" .$Email."";
            echo "<br>" .$Code."";
            echo "<br>" .$DateOfCode."";
            }

            if ($count == 0) {
                echo "This code is not in the database";
            }
    }

    
    

    
    ?>
  
  

</div>



</body>
</html>