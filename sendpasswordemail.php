<!DOCTYPE html>
<html lang="en" >
<head>
<title>Forgot Password</title>
  <script src= "libraries/papaparse.min.js" ></script>
  <script type="text/javascript" src="libraries/jquery-3.6.0.min.js"></script>
  <script src="uploadCSV/uploadCSV.js"></script>
  <link href="CSS/font_family.css" rel="stylesheet">
  <link href="CSS/faculty_home_page.css" rel="stylesheet">
    <link href="https://unpkg.com/nes.css@2.3.0/css/nes.min.css" rel="stylesheet" />
</head>
<body class="retro" style="margin-top:10vh; margin-bottom:30vh; margin-left:20vw; margin-right:20vw;">
    
    <div class="body" style="text-align: center">
        <p>Welcome to the Daily Roar!</p>
    </div>
  

<div class="nes-container with-title is-centered">
  <p class="title">Enter your Email Address</p>

    <?php
    include "dbconfig.php";
        if (isset($_POST['name_field'])){

            $email=$_POST['name_field'];
            $sql = "SELECT Email_Address FROM csemaildb.Login WHERE Email_Address = '$email' ";
            $result = mysqli_query($con, $sql);
            $count = mysqli_num_rows($result);

            if ($count > 0) {
                echo "That email is here in the system";
            }
            
            if ($count == 0){
                echo "That email is not here";
            }

            
        }
    ?>
  
  

</div>



</body>
</html>