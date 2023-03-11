<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<head>
    <script type="text/javascript" src="libraries/jquery-3.6.0.min.js"></script>
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
        <ul>
            <li class="option">
                <a href="home.php" class="btn">Home</a>
            </li>
            <li class="option">
                <a href="javascript:void(0)" class="btn">Email</a>
            </li>
        </ul>
    </div>
    <hr>
    <h2>Compose Email</h2>

    <div class="email_form">
        <label for="emailID">Email ID:</label>
        <input type="number" name="email_id" id="email_ID" required></textarea><br>
        
        <label for="subject">Subject:</label>
        <input type="text" name="subject" id="email_subject" required><br> 
    
        <label for="composer_address">From:</label>
        <input type="email" name="composer_address" id="email_composer" required><br>
        
        <label for="curriculum">Curricula: </label>
        <select name="curriculum" id="email_curriculum">

        </select>
        <label for="recipient_address">To: (ex: "fisheral@kean.edu,moffan@kean.edu,...,pankapatel@kean.edu")</label>
        <input type="text" name="recipient_address" id="email_recipients" required><br>
        
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
    
        <button type="button" id="form_submit">Send Email</button>
    </div>
    <div id="send_email_response"></div>
</body>

</html>