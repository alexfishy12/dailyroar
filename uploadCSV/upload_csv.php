
<?php include("../faculty_nav.php");  ?>

<body>

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