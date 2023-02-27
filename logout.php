<?php
if(!isset($_COOKIE['Account_type'])){
    header('Location: index.html');
    exit;
}else{
    header('Location: index.html');
    unset($_COOKIE['Account_type']);
    unset($_COOKIE['ID']);
    setcookie("Account_type","",time()-3600);
    setcookie("ID","",time()-3600);
    exit;
}
?>