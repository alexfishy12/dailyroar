<!DOCTYPE html>
<html lang="en" >
<head>
<title>Reset Password</title>
<script src= "../_libraries/papaparse.min.js" ></script>
  <script type="text/javascript" src="../_libraries/jquery-3.6.0.min.js"></script>
  <link href="../_CSS/font_family.css" rel="stylesheet">
  <link rel="stylesheet" href="../_CSS/background_static.css">
  <link rel="stylesheet" href="../_CSS/content.css">
  <link rel="icon" href="../_assets/Keanu_head.svg">
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
  <form action="newpassword.php" method="post">
    <div class="nes-field">
    <label for="name_field">Please Enter Reset Code</label>
    <input type="text" name="code" class="nes-input" required>
    </div>
  <button type= submit class="nes-btn button_format" style="margin:20px">Submit</a>
</form> 


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