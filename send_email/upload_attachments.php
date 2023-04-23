<?php
 //Get the name of the uploaded file 
 if(isset($_FILES['file'])) {
  $file_name = $_FILES['file']['name'];
  echo $file_name;
}
else 
echo "file is not retrived";

// Set maximum file size limit to 10MB
ini_set('upload_max_filesize', '40M');
ini_set('post_max_size', '40M');


echo ini_get('upload_max_filesize'); // outputs the current max file size limit 
echo ini_get('post_max_size'); // outputs the current max post size limit


//Choose where to save the uploaded file 
$targetFilePath = "../uploads/".$file_name;
$tempFilePath = $_FILES['file']['tmp_name'];


// Save the uploaded file to the local filesystem 
if ( move_uploaded_file($tempFilePath, $targetFilePath) ) 
  echo 'Success';  
else  
  echo 'Failure'; 


?>
