<?php 


include "../dbconfig.php";

echo "Feature disabled for demo purposes.";
die();

$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)
    or die("<br> Cannot connect to DB: $dbname on $host");

$lastNameArr= array();
$firstNameArr = array();
$activeProgramsArr = array();
$major1Arr = array();
$major2Arr = array();
$minorArr = array();
$classLevelArr = array();
$emailArr = array();

$jsonString = file_get_contents('php://input');

// decode the JSON payload into a PHP object
$data = json_decode($jsonString,true);



    // turn object inro array for manipulation
    foreach($data as $val)
    {
        $lastNameArr[] = $val["Last Name"];
        $firstNameArr[] = $val["First Name"];
        $activeProgramsArr[] = $val['Active Programs'];
        $major1Arr[] = $val['Major 1'];
        $major2Arr[] = $val['Major 2'];
        $minorArr[] = $val["Minors"];
        $classLevelArr[] = $val["Class Level"];
        $emailArr[] = $val["Kean Email"];

    }


    // combine all three arrays into one
    $curriculumAll = array_merge($major1Arr,$major2Arr,$minorArr);

    // only get unique majors
    $curriculumUnique = array_unique($curriculumAll);
    $activeProgramUnique = array_unique($activeProgramsArr);

    //remove nulls from array
    $filterCurriculum = array_filter($curriculumUnique);
    $filterActiveProgram = array_filter($activeProgramUnique);

    /////////////////// insert unique curriculm ////////////////////////////////// 
    foreach($filterCurriculum as $val1)
    {
        
        $insertCurriculum = "INSERT INTO Curriculum VALUES (NULL,'$val1')";
        $result = mysqli_query($con,$insertCurriculum);


        if(!$result)
            echo "There was an error adding majors";      
    }

    
   /////////////////// insert all active programs  //////////////////////////////////
   foreach($filterActiveProgram as $val2)
   {
       
       $insertActivePrograms = "INSERT INTO ActiveProgram VALUES (NULL,'$val2')";
       $result = mysqli_query($con,$insertActivePrograms);


       if(!$result)
           echo "There was an error adding majors";      
   }

  /////////////////// get major id and insert student //////////////////////////////////
   for($i = 0; $i < count($lastNameArr); $i++)
   {
        
        $getActiveProgramId = "SELECT id AS activeProgram FROM ActiveProgram  WHERE ActiveProgram = '$activeProgramsArr[$i]'";
        $getMajor1Id = "SELECT id as major1  FROM Curriculum WHERE Curriculum = '$major1Arr[$i]' ";
        $getMajor2Id = "SELECT id as major2 FROM Curriculum WHERE Curriculum = '$major2Arr[$i]'";
        $getMinorId = "SELECT id as minor FROM Curriculum WHERE Curriculum = '$minorArr[$i]'";
        $getClassStandingId = "SELECT id AS classStanding FROM ClassStanding WHERE Standing = '$classLevelArr[$i]'";
        

        $activeProgramResultId = mysqli_query($con, $getActiveProgramId);
        $major1ResultId = mysqli_query($con, $getMajor1Id);
        $major2ResultId= mysqli_query($con, $getMajor2Id);
        $minorResultId = mysqli_query($con, $getMinorId);
        $classLevelResultId = mysqli_query($con,$getClassStandingId);

        /////////////////// active program ID //////////////////////////////////
        if($activeProgramResultId)
        {
            if(mysqli_num_rows($activeProgramResultId) > 0)
            {
                while($row1 = mysqli_fetch_array($activeProgramResultId))
                {
                    $activeProgramId = $row1["activeProgram"];
                }
            }
            else 
                $activeProgramId = "NULL";

            //echo $activeProgramId. "\n";
        }
        else 
            echo "There is an error";

        /////////////////// major1 id //////////////////////////////////
        if($major1ResultId)
        {
            if(mysqli_num_rows($major1ResultId) > 0 )
            {
                while($row2 = mysqli_fetch_array($major1ResultId))
                {
                    $major1Id = $row2["major1"];
                }
            }
            else 
                $major1Id = "NULL";
            
            //echo $major1Id. "\n";
        }
        else 
            echo "There is an error";

        /////////////////// major2 id //////////////////////////////////
        if($major2ResultId)
        {
            if(mysqli_num_rows($major2ResultId) > 0 )
            {
                while($row3 = mysqli_fetch_array($major2ResultId))
                {
                    $major2Id = $row3["major2"];
                }
            }
            else 
                $major2Id = "NULL";
            
            //echo $major2Id. "\n";
        }
        else
            echo "There is an error";

        /////////////////// minor id //////////////////////////////////
        if($minorResultId)
        {
            if(mysqli_num_rows($minorResultId) > 0 )
            {
                while($row4 = mysqli_fetch_array($minorResultId))
                {
                    $minorId = $row4["minor"];
                }
            }
            else 
                $minorId = "NULL";
            
            //echo $major2Id. "\n";
        }
        else 
            echo "There is an error";

        /////////////////// class standing id  //////////////////////////////////

        if($classLevelResultId)
        {
            if(mysqli_num_rows($classLevelResultId) > 0 )
            {
                while($row5 = mysqli_fetch_array($classLevelResultId))
                {
                    $classLevelId= $row5["classStanding"];
                }
            }
            else 
                $classLevelId = "NULL";
            
           // echo $classLevelId. "\n";
        }
        else 
            echo "There is an error";

        /////////////////// Check is other columns are empty  //////////////////////////////////

        if(empty($lastNameArr[$i]))
            $lastName = "NULL";
        else 
            $lastName = mysqli_real_escape_string($con,$lastNameArr[$i]);

        if(empty($firstNameArr[$i]))
            $firstName = "NULL";
        else 
            $firstName = mysqli_real_escape_string($con,$firstNameArr[$i]);

        if(empty($emailArr[$i]))
            $email = "NULL";
        else 
            $email = $emailArr[$i];


        // echo $firstName."\n";
        // echo $lastName."\n";
        // echo $activeProgramId."\n";
        // echo $major1Id."\n";
        // echo $major2Id."\n";
        // echo $minorId."\n";
        // echo $classLevelId."\n";
        // echo $email."\n";
      
      $insertStudent = "INSERT INTO Students 
                        VALUES(NULL,'$firstName', '$lastName',$activeProgramId,$major1Id, $major2Id,$minorId,$classLevelId,'$email' )";

       $insertResult = mysqli_query($con, $insertStudent);
        if(!$insertResult) {
            echo "<b>There is an error inserting student: $firstName $lastName. See error below.</b><br>";
            echo mysqli_error($con) . "<br><br>";
        }


       
   }
?>