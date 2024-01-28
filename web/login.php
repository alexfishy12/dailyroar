<?php
    include "dbconfig.php";
    include "_functions.php";
    session_start();

    try {
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
        if ($stmt->errorCode() !== '00000') {
            return_json_failure("Authentication error");
        }
    
        $response = $stmt->fetch()[0];
        if (!str_contains($response, "Success")) {
            return_json_failure($response);
        }
    
        $query = "select * from Login where Email_Address = :email;";
        $stmt = $pdo ->prepare($query);
        $stmt->bindParam(":email", $user, PDO::PARAM_STR);
        $stmt->execute();
        if ($stmt->errorCode() !== '00000') {
            return_json_error("Unable to retrieve account information.");
        }
    
        $response = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION["user"] = $user;
        $_SESSION['account_type'] = $response['Account_Type'];
        $_SESSION['id'] = $response['ID'];
    
        // get active semester and set as session variable
        $query = "SELECT * from Semester where IsActive = 1";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
    
        if ($stmt->errorCode() === "00000") {
            $response = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['semester'] = $response["Semester"] . " " . $response['Year'];
        }
        else {
            $_SESSION['semester'] = null;
        }
    
    
        $_SESSION["start"] = time();
        $_SESSION['expire'] = $_SESSION['start'] + (3600);
    
        if($_SESSION['account_type']=="FA"){
            return_json_success("Faculty_Home.php");
        }
        else{
            return_json_success("GA_Home.php");
        }    
    }
    catch(Exception $e) {
        return_json_error($e->getMessage());
    }
?>
