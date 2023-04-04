
<?php include("../faculty_nav.php");  ?>


<link rel="stylesheet" href="/dailyroar/CSS/faculty_home_page.css">
<link href="/dailyroar/CSS/font_family.css" rel="stylesheet">
    <link href="https://unpkg.com/nes.css@2.3.0/css/nes.min.css" rel="stylesheet" />

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