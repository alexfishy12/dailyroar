<?php
include ("../faculty_nav.php");
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
    header("Location: index.php");  
}
?>
<!DOCTYPE html>
<head>
    <script type="text/javascript" src="../libraries/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="email.js"></script>

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
<body>
    <div class="title">Daily Roar - Email</div>
    <div class="menu">
    </div>
    <hr>
    <h2>Compose Email</h2>

    <div class="email_form">       
        <label for="curriculum"><b>Curricula:</b></label>
        <div name="curriculum" id="curriculum" multiple>
            
        </div>
        <label for="class_standing"><b>Class Standings:</b></label>
        <div name="class_standing" id="class_standings" multiple>
            
        </div>
        <label for="subject">Subject:</label>
        <input type="text" name="subject" id="email_subject" required><br> 
        
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
        <!-- END OF EXAMPLE QUILL CODE -->
        <input type="file" id="email_attachments" name="attachments">
       <!-- <button id='upload'>Upload attachments</button>-->
    
        <button type="button" id="form_submit">Send Email</button>
    </div>
    <div id="get_response"></div>
    <br>
    <div id="send_email_response"></div>
    <br>
    <div id="send_email_errors"></div>
</body>

</html>