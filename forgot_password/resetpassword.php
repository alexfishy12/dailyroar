<!DOCTYPE html>
<html lang="en" >
<head>
<title>Reset Password</title>
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
  <p class="title">Reset Password</p>
  <form action="newpassword.php" method="post">

    <div class="nes-field">
    <label for="name_field">Reset Code</label>
    <input type="text" name="code" class="nes-input" required>
    </div>
  <button type= submit class="nes-btn button_format" style="margin:20px">Submit</a>
</form> 


</div>



</body>
</html>