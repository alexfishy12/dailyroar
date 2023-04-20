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
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="analysis.js"></script>
    <link rel="stylesheet" href="../CSS/background_static.css">
  <link rel="stylesheet" href="../CSS/content.css">
  <link rel='stylesheet' href="../CSS/analysis.css">
  <link href="../CSS/font_family.css" rel="stylesheet">
    <link href="https://unpkg.com/nes.css@2.3.0/css/nes.min.css" rel="stylesheet" />

    
</head>
<title id="title">Daily Roar - Analysis</title>
<nav class= "retro">
<?php 
include("../faculty_nav.php"); 
?>
</header>

<body class='retro' background-image="assets/Background.png"  background-size="cover" style="background-color:#0c5eb3;">
  <div class='title'>
    Email Analysis
</div>
<div class="scroll">
  <div class="content">
        <div class="nes-container with-title is-centered" style="background:rgba(0,0,0,0.5)">
                <button class="nes-btn is-primary" id="select_email_analysis">Email Analysis</button>
                <button class="nes-btn is-primary" id="select_filtered_analysis">Filtered Analysis</button>
                <div id="email_analysis">
                Sent Emails:
                <div class="email_table" id="email_table">
                </div>
                </div>
                <div id="filtered_analysis">
                    <b><u>Filtered Analysis:</u></b>
                    <div id="get_response"></div>
                    <br>
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
                    <button type="button" class="nes-btn is-primary" id="form_submit">Retrieve Analysis</button>
                </div>
                <br><hr>
                <b>Data:</b><br>
            <div id="charts_response">
                <div id="data_chart" style='text-align:center;width:75%;margin-right:12.5%;margin-left:12.5%;'></div>
            </div>
            <div id="email_data"></div>
            <div id="chart_errors"></div>
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