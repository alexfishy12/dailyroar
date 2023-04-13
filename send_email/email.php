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
<head>
    <script type="text/javascript" src="../libraries/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="email.js"></script>
    <link rel="stylesheet" href="../CSS/background_static.css">
  <link rel="stylesheet" href="../CSS/content.css">
  <link href="../CSS/font_family.css" rel="stylesheet">
    <link href="https://unpkg.com/nes.css@2.3.0/css/nes.min.css" rel="stylesheet" />

    <!-- Quill -->
    <!-- Main Quill library -->
    <script src="https://cdn.quilljs.com/1.0.0/quill.js"></script>
    <script src="//cdn.quilljs.com/1.0.0/quill.min.js"></script>
    
    <!-- Theme included stylesheets -->
    <link href="//cdn.quilljs.com/1.0.0/quill.snow.css" rel="stylesheet">
    <link href="//cdn.quilljs.com/1.0.0/quill.bubble.css" rel="stylesheet">
    <link href="https://cdn.quilljs.com/1.0.0/quill.snow.css" rel="stylesheet">

    <!-- Core build with no theme, formatting, non-essential modules -->
    <link href="//cdn.quilljs.com/1.0.0/quill.core.css" rel="stylesheet">
    <script src="//cdn.quilljs.com/1.0.0/quill.core.js"></script>
    <script src="https://cdn.quilljs.com/1.0.0/quill.js"></script>
    <!-- End of Quill -->
</head>
<title id="title">Daily Roar - Email</title>
<nav class= "retro">
<?php 
include("../faculty_nav.php"); 
?>
</header>

<body class='retro' background-image="assets/Background.png"  background-size="cover" style="background-color:#0c5eb3;">
  <div class='title'>
    Compose Email
</div>
<div class="scroll">
  <div class="content">
        <div class="nes-container with-title is-centered" style="background:rgba(0,0,0,0.5)">
            
                <label for="curriculum"><b>Curriculum:</b></label>
                <div name="curriculum" id="curriculum" class="nes-select" multiple>
                    
                </div>
                <label for="class_standing"><b>Class Standings:</b></label>
                <div name="class_standing" id="class_standings" class="nes-select" multiple>
                    
                </div>
                <div class="nes-field">
                <label for="subject">Subject:</label>
                <input type="text" name="subject" id="email_subject" class="nes-input" required><br> 
                </div>
                <!-- EXAMPLE QUILL CODE -->
                    <!-- Create the toolbar container -->
                    <div id="toolbar">
                    <button class="ql-bold">Bold</button>
                    <button class="ql-italic">Italic</button>
                    </div>
            
                    <!-- Create the editor container -->
                    <div form="email" name="body" id="email_editor">
                        <p>Welcome to The Daily Roar!</p>
                    </div>
                    <br>
                <!-- END OF EXAMPLE QUILL CODE -->
                <label class="nes-btn is-primary">
                <span> Select Your File</span>
                <input type="file" id="email_attachments" name="attachments">
                </label>
                <!-- <button id='upload'>Upload attachments</button>-->
                <button type="button" class="nes-btn is-primary" id="form_submit">Send Email</button>
            
            
            <div id="get_response"></div>
            <br>
            <div id="send_email_response"></div>
            <br>
            <div id="send_email_errors"></div>
        </div>
    </div>
  </div>
</div>


  <div class="background_parent">
      <img class='pixel_perfect keanu' src='../assets/Keanu_Walk_FULLSCREEN.gif'></img>
      <img class='pixel_perfect foreground primary-fg' src='../assets/Foreground_1.png'></img>
      <img class='pixel_perfect middleground primary-mg' src='../assets/Middleground_2.png'></img>
      <img class='pixel_perfect background' src='../assets/Background.png'></img>
  </div>
</body>

</html>