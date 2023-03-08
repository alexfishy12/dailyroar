<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<head>
    <!-- <script type="text/javascript" src="index.js"></script> -->
</head>
<title id="title">Daily Roar</title>
<body>
    <div class="title">Daily Roar - Home</div>
    <div class="menu">
        <ul>
            <li class="option">
                <a href="javascript:void(0)" class="btn">Home</a>
            </li>
            <li class="option">
                <a href="email.php" class="btn">Email</a>
            </li>
        </ul>
    </div>
    <div class="body">
        <p>Welcome to the Daily Roar!</p>
    </div>
    <div class="logout">
        <a href="logout.php">logout</a>
    </div>
</body>
</html>