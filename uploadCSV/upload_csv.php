
<?php include("../faculty_nav.php");  ?>


<link rel="stylesheet" href="/dailyroar/CSS/faculty_home_page.css">

<body class="retro">

    <div class="title">Daily Roar - Upload CSV</div>

    <div class="body">
        <p>Upload CSV</p>
    </div>
    <div>
        <input type = "file" id = "uploadcsv" name = "uploadcsv" onchange = "readCSV();">
    </div>
    <div id="responseMessage"></div>



</body>
</html>