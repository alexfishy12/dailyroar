<!DOCTYPE html>
<html lang="en" >
<head>
<title>Your Password Has Been Reset</title>
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
  <p class="title">Your Password Has Been Reset</p>

  <?php
    include "dbconfig.php";
        if (isset($_POST['password2'])){
            $newpassword=$_POST['password2'];
            $email=$_POST['Email'];


            $sql = "UPDATE Customers FROM csemaildb.Login SET Password = '$newpassword' WHERE Email_Address = '$email';";
            $result = mysqli_query($con, $sql);

        }
  
?>
</div>



</body>
</html>