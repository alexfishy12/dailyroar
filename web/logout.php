<?php
session_start();
if(isset($_SESSION["user"])){
    session_destroy();
    unset($_SESSION["user"]);
    unset($_SESSION['account_type']);
    unset($_SESSION['semester']);
    header("Location: index.php");
}
else{
    echo "error";
}
?>