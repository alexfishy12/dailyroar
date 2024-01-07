<?php 
    session_start();
    echo "<b>Session Variables</b><br>";
    echo "Session ID: " . session_id() . "<br>";
    echo "Session Name: " . session_name() . "<br>";
    echo "Session Status: " . session_status() . "<br>";
    echo "Session Save Path: " . session_save_path() . "<br>";
    echo "Session Cookie Lifetime: " . session_get_cookie_params()["lifetime"] . "<br>";
    echo "Session Cookie Path: " . session_get_cookie_params()["path"] . "<br>";
    echo "Session Cookie Domain: " . session_get_cookie_params()["domain"] . "<br>";
    echo "Session Cookie Secure: " . session_get_cookie_params()["secure"] . "<br>";
    echo "Session Cookie HTTP Only: " . session_get_cookie_params()["httponly"] . "<br>";
    echo "Session Cookie SameSite: " . session_get_cookie_params()["samesite"] . "<br>";
    echo "Session Cookie Name: " . session_name() . "<br>";
    echo "Session Cookie Value: " . $_COOKIE[session_name()] . "<br>";

    echo "<br><br><br>";

    echo "Semester: " . $_SESSION['semester'] . "<br>";

?>