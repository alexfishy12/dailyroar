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
    <script type="text/javascript" src="../_libraries/jquery-3.6.0.min.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="../_functions.js"></script>
    <script type="text/javascript" src="analysis.js"></script>
    <link rel="icon" href="../_assets/Keanu_head.svg">
    <link rel="stylesheet" href="../_CSS/background_static.css">
  <link rel="stylesheet" href="../_CSS/content.css">
  <link href="../_CSS/font_family.css" rel="stylesheet">
  <link href="https://unpkg.com/nes.css@2.3.0/css/nes.min.css" rel="stylesheet" />
  <link rel='stylesheet' href="../_CSS/analysis.css">
  
  <link href="https://cdn.quilljs.com/1.1.10/quill.snow.css" rel="stylesheet" />
  <script src="https://cdn.quilljs.com/1.1.10/quill.min.js"></script>
  
    
</head>
<title id="title">Daily Roar - Sent Inbox</title>
<nav class= "retro">
<?php 
include("../faculty_nav.php"); 
?>
</header>

<body class='retro' background-image="_assets/Background.png"  background-size="cover" style="background-color:#0c5eb3;">
  <div class='subtitle'>
    Sent Inbox
</div>
  <div class="content">
        <div class="inbox_tab_list">
            <div class="tab selected text-unselectable" id="main"><?php echo $_SESSION['semester']; ?></div>
            <div class="tab text-unselectable" id="archive">Archive</div>
        </div>
        <div class="scroll">

            <div class="nes-container with-title is-centered">
                <div class="master_content">
                    <div class="data_content" id="main_content">
                        <div class="email_table" id="email_table">
                        </div>
                    </div>
                    <div class="data_content" id="archive_content">
                        <div class="select_semester">
                           <span class="label"><b>Viewing emails from:</b></span>
                            <select id="semester"></select> 
                        </div>
                        
                        <hr>
                        <div class="email_table" id="archive_table">
                            
                        </div>
                    </div>
                </div>
                <div id="selected_email" class="selected_email">
                    <button class="nes-btn" id="go_back">Go back</button>
                    <hr>
                    <div id="email_metadata" class="email_metadata"></div><br>
                    <b><u>Body</u></b><br><br>
                    <div form="email" name="body" id="editor" class='editor_container'></div><br>
                    <div id="email_data"></div><br>
                    <div id="charts_response">
                        <div id="data_chart" style='text-align:center;width:75%;margin-right:12.5%;margin-left:12.5%;'></div>
                    </div>
                    <div id="chart_errors"></div>
                    <div id="recipient_filters" style="margin-top:25px;margin-bottom:25px;"></div>
                </div>
                    
                    <!-- The following code is for filtered analysis -->
                    <!--
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
    
                            
                            </select>
                        </div>
                        </div>
                        <button type="button" class="nes-btn is-primary" id="form_submit">Retrieve Analysis</button>
                    </div>
                    <br><hr>
                        -->
            </div>
        </div>
    </div>
  </div>


  <div class="background_parent">
      <img class='pixel_perfect keanu' src='../_assets/Keanu_Idle_FULLSCREEN.gif'></img>
      <img class='pixel_perfect foreground primary-fg' src='../_assets/Foreground_1.png'></img>
      <img class='pixel_perfect middleground primary-mg' src='../_assets/Middleground_2.png'></img>
      <img class='pixel_perfect background' src='../_assets/Background.png'></img>
  </div>
</body>

</html>