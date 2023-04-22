<?php
 //Get the name of the uploaded file 
 if(isset($_FILES['file'])) {
  $file_name = $_FILES['file']['name'];
  echo $file_name;
}
else 
echo "file is not retrived";

//Choose where to save the uploaded file 
$targetFilePath = "../uploads/".$file_name;
$tempFilePath = $_FILES['file']['tmp_name'];


// Save the uploaded file to the local filesystem 
if ( move_uploaded_file($tempFilePath, $targetFilePath) ) 
  echo 'Success';  
else  
  echo 'Failure'; 


?>
