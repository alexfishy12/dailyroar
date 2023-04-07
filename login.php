<?php
    include "dbconfig.php";
    session_start();

    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", "$dbuser", "$dbpass");

    $user=strtolower($_POST['login_id']);
    $pass=$_POST['password'];

    $query = "CALL Try_Login(:email, :password);";

    // Prepare the query
    $stmt = $pdo->prepare($query);
            
    // Bind the login parameters
    $stmt->bindParam(":email", $user, PDO::PARAM_STR);
    $stmt->bindParam(":password", $pass, PDO::PARAM_STR);


    // Execute the query
    $stmt->execute();

    // Fetch the result
    if ($stmt->errorCode() === '00000') {
        $response = $stmt->fetch()[0];
        if (str_contains($response, "Success")) {
            $_SESSION["user"] = $user;
            $_SESSION['account_type'] = $row['Account_Type'];
            $_SESSION['id'] = $row['ID'];
            $_SESSION["start"] = time();
            $_SESSION['expire'] = $_SESSION['start'] + (60 * 10) ; 
            if($_SESSION['account_type']=="FA"){
                header("Location: Faculty_Home.php");
            }
            else{
                header("location: GA_Home.php");
            }
        }
        else {
            echo $response;
            //header("refresh:2;url=index.php");
        }
    }
    else {
        echo $pdo->errorInfo()[2];
        echo "Authentication error";
        die();
    }
?>
