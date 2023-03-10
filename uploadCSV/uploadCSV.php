<?php 

$major1 = array();
$major2 = array();
$minor = array();

$jsonString = file_get_contents('php://input');

// decode the JSON payload into a PHP object
$data = json_decode($jsonString,true);




foreach($data as $val)
{
    $major1[] = $val['Major 1'];
    $major2[] = $val['Major 2'];
    $minor[] = $val["Minors"];

}

    
    $distinctMajor1 = array_unique($major1);
    $distinctMajor2 = array_unique($major2);
    $distinctMinor = array_unique($minor);

    $activePrograms = array_merge($distinctMajor1,$distinctMajor2, $distinctMinor);
    $filterActivePrograms = array_filter($activePrograms);

foreach($activePrograms as $arr)
{
    echo $arr. "\n";

}


?>