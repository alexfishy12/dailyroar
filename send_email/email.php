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


    $directoryName = "dailyroar/uploads";

    // Check if the directory already exists
    if(!is_dir($directoryName)){
    
      // Create the directory
      mkdir($directoryName);
    
      // Display a success message
      echo "Directory created successfully.";
    
    } else {
    
      // Display an error message
      echo "Directory already exists.";
    
    }

}
?>
<!DOCTYPE html>
<head>
    <script type="text/javascript" src="../libraries/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="email.js"></script>
    <link rel="icon" href="../assets/Keanu_head.svg">
    <link rel="stylesheet" href="../CSS/background_static.css">
  <link rel="stylesheet" href="../CSS/content.css">
  <link rel='stylesheet' href="../CSS/email.css">
  <link href="../CSS/font_family.css" rel="stylesheet">
    <link href="https://unpkg.com/nes.css@2.3.0/css/nes.min.css" rel="stylesheet" />

    <!-- Quill -->
    <!-- Main Quill library -->
    <link href="https://cdn.quilljs.com/1.1.10/quill.snow.css" rel="stylesheet" />
    <script src="https://cdn.quilljs.com/1.1.10/quill.min.js"></script>

   
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
          <div id="compose_email_form">
            <b><u>Select Recipients via Filters</u></b><br><br>
            Curriculum:
            <div class="row small-text">
              <div class="column side">
                Unselected
                <select id='curriculum' size='4' multiple>
                  
                </select>
              </div>
              <div class="column middle" style="margin-top:20px;margin-bottom:20px;">
                  <button id='curriculum_select_all' class='nes-btn is-primary filter_button'>Select All</button><br>
                  <button id='curriculum_remove_all' class='nes-btn is-error filter_button'>Remove All</button><br>
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
              <div class="column middle" style="margin-top:20px;margin-bottom:20px;">
                  <button id='standing_select_all' class='nes-btn is-primary filter_button'>Select All</button><br>
                  <button id='standing_remove_all' class='nes-btn is-error filter_button'>Remove All</button><br>
              </div>  
              <div class="column side">
                Selected
                <select id='selected_class_standing' size='5' multiple>
                  <!-- This area will be dynamically added with options depending on which ones were chosen -->
                  
                </select>
              </div>
            </div>
            <div id="get_response"></div>
            <div class="nes-field">
            <label for="subject">Subject:</label>
            <input type="text" name="subject" id="email_subject" class="nes-input" placeholder="Enter email subject..." required><br> 
            </div>
            <!-- EXAMPLE QUILL CODE -->
            <div class="quill_editor">
                <!-- Create the toolbar container -->
                <div id="toolbar">
                </div>
        
                <!-- Create the editor container -->
                <div form="email" name="body" id="editor" class='editor_container'>
                  BOOM <a href="https://www.google.com" target="_blank">LINK</a>
                </div>
            </div>
                <br>
             <div class = "file_names">  
                <p id = "fileList"></p>

              </div>
            
            <label class="nes-btn is-primary">
                <span> Select Your File</span>
                <input type="file" id="email_attachments" name="attachments" accept=".pdf,.jpg,.png,.jpeg" multiple>
                </label>
            <!-- <button id='upload'>Upload attachments</button>-->
            <div id="submit_error" style="color:red; margin-bottom:25px"></div>
            <button type="button" class="nes-btn is-primary" id="form_submit">Send Email</button>
          </div>
          <div id="send_response">
            <button id="view_sent_email" class="nes-btn is-primary">View Sent Email</button>
            <div id="total_recipient_count"></div>
            <div id="send_email_response"></div>
            <div id="send_email_errors" style='color:red'></div>
          </div>
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