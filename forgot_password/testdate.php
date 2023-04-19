<?php
    include "dbconfig.php";


    $sqltime = "SELECT DateOfCode FROM csemaildb.PasswordCode WHERE Code = '$enteredcode' ";
            $resulttime = mysqli_query($con, $sql);
            $row = mysqli_fetch_assoc($resulttime);
            $datetime = $row['DateOfCode'];
            
            $current_time = new DateTime();
            $datetime_value = new DateTime($datetime);

            $diff = $current_time->diff($datetime_value);


            echo $diff->format('%H:%I:%S'); 
    ?>