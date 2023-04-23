<?php



//echo ini_get('upload_max_filesize'); // outputs the current max file size limit 
//echo ini_get('post_max_size'); // outputs the current max post size limit


//Choose where to save the uploaded file 

 //Get the name of the uploaded file 
 if(isset($_FILES['file'])) {

  $file_name = $_FILES['file']['name'];

  // Loop through each uploaded file
  foreach ( $file_name as $i => $name) {

    // Get uploaded file name
    $targetFilePath = "../uploads/".$name;

    // Get the temporary filename
    $tempFilePath = $_FILES['file']['tmp_name'][$i];
    echo $name ." upload: ";

    // Save the uploaded file to the local filesystem 
    if ( move_uploaded_file($tempFilePath, $targetFilePath) ) 
      echo 'Success';  
    else  
      echo 'Failure'; 
  }



 



}
else 
echo "file is not retrived";



?>
