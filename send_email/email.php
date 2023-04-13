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
  <link rel='stylesheet' href="../CSS/email.css">
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
    Compose an Email
</div>
<div class="scroll">
  <div class="content">
        <div class="nes-container with-title is-centered" style="background:rgba(0,0,0,0.5)">
                Curriculum:
                <div class="row small-text">
                  <div class="column side">
                    Unselected
                    <select id='curriculum' size='4' multiple>
                      
                    </select>
                  </div>
                  <div class="column middle">
                      <button id='curriculum_select_all' class='nes-btn is-primary'>Select All</button><br>
                      <button id='curriculum_remove_all' class='nes-btn is-error'>Remove All</button><br>
                  </div>  
                  <div class="column side">
                    Selected
                    <select id='selected_curriculum' size='4' multiple>
                      <!-- This area will be dynamically added with options depending on which ones were chosen -->
                      
                    </select>
                  </div>
                </div>

                Class Standing:
                <div class="row small-text">
                  <div class="column side">
                    Unselected
                    <select id='class_standing' size='5' multiple>
                    
                    </select>
                  </div>
                  <div class="column middle">
                      <button id='standing_select_all' class='nes-btn is-primary'>Select All</button><br>
                      <button id='standing_remove_all' class='nes-btn is-error'>Remove All</button><br>
                  </div>  
                  <div class="column side">
                    Selected
                    <select id='selected_class_standing' size='5' multiple>
                      <!-- This area will be dynamically added with options depending on which ones were chosen -->
                      
                    </select>
                  </div>
                </div>
                
                <div class="nes-field">
                <label for="subject">Subject:</label>
                <input type="text" name="subject" id="email_subject" class="nes-input" required><br> 
                </div>
                <!-- EXAMPLE QUILL CODE -->
                    <!-- Create the toolbar container -->
                    <div id="toolbar" class='editor_toolbar'>
                    <button class="ql-bold">Bold</button>
                    <button class="ql-italic">Italic</button>
                    </div>
            
                    <!-- Create the editor container -->
                    <div form="email" name="body" id="email_editor" class='editor_container'>
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
      <img class='pixel_perfect keanu' src='../assets/Keanu_Idle_FULLSCREEN.gif'></img>
      <img class='pixel_perfect foreground primary-fg' src='../assets/Foreground_1.png'></img>
      <img class='pixel_perfect middleground primary-mg' src='../assets/Middleground_2.png'></img>
      <img class='pixel_perfect background' src='../assets/Background.png'></img>
  </div>
</body>

</html>