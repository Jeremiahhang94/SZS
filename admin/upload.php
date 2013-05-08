<?php
 
include_once 'admin-includes.php';
ob_end_clean();

print_r($_POST);
print_r($_FILES);

/*
$error = $_FILES['images']['error'];
if ($error == UPLOAD_ERR_OK) {  
	$name = $_FILES["images"]["name"];  
    move_uploaded_file( $_FILES["images"]["tmp_name"], "profiles/" . $_FILES['images']['name']);  
}  
*/

  
echo "<h2>Successfully Uploaded Images</h2>";  

?>