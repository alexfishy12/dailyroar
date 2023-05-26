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

    if (!function_exists('str_contains')) {
        function str_contains($haystack, $needle) {
            return $needle !== '' && mb_strpos($haystack, $needle) !== false;
        }
    }
    
    // Fetch the result
    if ($stmt->errorCode() === '00000') {
        $response = $stmt->fetch()[0];
        if (str_contains($response, "Success")) {
            $query = "select * from Login where Email_Address = :email;";
            $stmt = $pdo ->prepare($query);
            $stmt->bindParam(":email", $user, PDO::PARAM_STR);
            $stmt->execute();
            if ($stmt->errorCode() === '00000') {
                $response = $stmt->fetch(PDO::FETCH_ASSOC);
                $_SESSION["user"] = $user;
                $_SESSION['account_type'] = $response['Account_Type'];
                $_SESSION['id'] = $response['ID'];
                $_SESSION["start"] = time();
                $_SESSION['expire'] = $_SESSION['start'] + (3600) ; 
                
                if($_SESSION['account_type']=="FA"){
                    echo "Location:Faculty_Home.php";
                    die();
                }
                elseif($_SESSION['account_type']=="AD"){
                    echo "Location:Admin_Home.php";
                    die();
                }
                else{
                    echo "Location:GA_Home.php";
                    die();
                }
            }
            else {
                echo "ERROR:Unable to retrieve account information.";
                die();
            }
        }
        else {
            echo $response;
            die();
        }
    }
    else {
        echo "ERROR:Authentication error";

        die();
    }
?>
