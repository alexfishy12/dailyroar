<!DOCTYPE html>
<html lang="en" >
<head>
<title>Forgot Password</title>
  <script src= "../libraries/papaparse.min.js" ></script>
  <script type="text/javascript" src="../libraries/jquery-3.6.0.min.js"></script>
  <script src="../uploadCSV/uploadCSV.js"></script>
  <link href="../CSS/font_family.css" rel="stylesheet">
  <link href="../CSS/background_static.css" rel="stylesheet">
  <link href="../CSS/content.css" rel="stylesheet">
    <link href="https://unpkg.com/nes.css@2.3.0/css/nes.min.css" rel="stylesheet" />
</head>
<body class="retro" background-image="assets/Background.png"  background-size="cover" style="background-color:#0c5eb3;">
    
    <div class="title" style="text-align: center">
        <p>Welcome to the Daily Roar!</p>
    </div>
  
<div class="content">
<div class="logout">
                <a href="../index.php">Back To Login</a>
            </div>
<div class="nes-container with-title is-centered" style="background:rgba(0,0,0,0.5)">
  <p class="label">Enter your Email Address</p>

    <?php
    include "../dbconfig.php";
        if (isset($_POST['name_field'])){

            $email=$_POST['name_field'];
            $sql = "SELECT Email_Address FROM csemaildb.Login WHERE Email_Address = '$email' ";
            $result = mysqli_query($con, $sql);
            $count = mysqli_num_rows($result);

            if ($count > 0) {
                echo "A message with a reset code will be sent to your email.";
                $code = sprintf("%06d", mt_rand(1, 999999));
                echo "<br>";
                $sqlcode = "INSERT INTO csemaildb.PasswordCode VALUES (NULL, '$email', '$code', CURRENT_TIMESTAMP()) ";
                $resultcode = mysqli_query($con, $sqlcode);

                $to = $email;
                $subject = "Daily Roar Password Reset For " .$email. "";

                $txt = "This email has been sent to reset your password. Here is your temporary reset code and link: ".$code." https://obi.kean.edu/~fisheral/dailyroar/forgot_password/resetpassword.php .";
                $headers = "From: Daily Roar System <noreply@dailyroar.com>\r\n";

                mail($to,$subject,$txt,$headers);
            }

            if ($count == 0){
                echo "The email you have entered is not in the system. Please enter a viable email.";
            }

            
        }
    ?>
  
  

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