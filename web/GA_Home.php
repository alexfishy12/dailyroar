<?php
session_start();
if(!isset($_SESSION['account_type'])){
    header("Location: index.php");
    exit;
}
elseif(isset($_SESSION['account_type']) && $_SESSION['account_type']=="FA"){
    header("Location: Faculty_Home.php");
    exit;
}
$now=time();
if($now > $_SESSION['expire']) {
    session_destroy();
    header("Location: index.php");  
}
?>
<!DOCTYPE html>
<html lang="en" >
<head>

  
  <title>GA Home Page </title>
  <audio autoplay="" loop="" src="./Wii_Music.mp3"></audio>
  <script src= "_libraries/papaparse.min.js" ></script>
  <script type="text/javascript" src="_libraries/jquery-3.6.0.min.js"></script>
  <script src="uploadCSV/uploadCSV.js"></script>
  <link rel="icon" href="_assets/Keanu_head.svg">
  <link href="https://unpkg.com/nes.css@2.3.0/css/nes.min.css" rel="stylesheet" />
	<link href="_CSS/font_family.css" rel="stylesheet">
    <link href="_CSS/background_moving.css" rel="stylesheet" type="text/css"/>
    <link href="_CSS/content.css" rel="stylesheet" type="text/css"/>
</head>
<!-- CSS Only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

<header>
  <nav class="navbar navbar-expand-lg navbar-dark" >
    <div class="container-fluid">
      <!--<a class="navbar-brand" style="cursor: pointer;" href="../Faculty_Home.php">
        <img id="logo" src="../_assets/Kean_University_Logo.svg.png" alt="Kean Logo" height="50" width="50">
      </a>-->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
        <ul class="navbar-nav">

        <li class="nav-item">
            <a class="nav-link" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="uploadCSV/upload_CSV.php">Upload CSV</a>
            </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>
<body class='retro' background-image="assets/Background.png"  background-size="cover" style="background-color:#0c5eb3;">
    <div class="title">
         The Daily Roar
    </div>
    <div class="subtitle">
        <?php echo $_SESSION['semester']; ?>
    </div>
    <!--
    <div class="scroll">
        <div class="content">
                
                <div class="nes-container with-title is-centered">
                    <a href="uploadCSV/upload_CSV.php" class="nes-btn button_format" style="margin:20px">Upload Students CSV</a>
                </div>
        </div>
    </div>  
    -->
    <div class="background_parent">
        <img class='pixel_perfect keanu' src='_assets/Keanu_Walk_FULLSCREEN.gif'></img>
        <img class='pixel_perfect foreground primary-fg' src='_assets/Foreground_1.png'></img>
        <img class='pixel_perfect foreground secondary-fg' src='_assets/Foreground_2.png'></img>
        <img class='pixel_perfect foreground tertiary-fg' src='_assets/Foreground_1.png'></img>
        <img class='pixel_perfect middleground primary-mg' src='_assets/Middleground_2.png'></img>
        <img class='pixel_perfect middleground secondary-mg' src='_assets/Middleground_2.png'></img>
        <img class='pixel_perfect middleground tertiary-mg' src='_assets/Middleground_2.png'></img>
        <img class='pixel_perfect background' src='_assets/Background.png'></img>
    </div>
</body>


</html>