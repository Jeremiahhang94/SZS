<?php
include_once 'admin-includes.php';
ob_end_clean();

isLoggedIn();

$name = $_POST['profileName'];
$desc = $_POST['profileDesc'];
$achi = $_POST['profileAchi'];
$purpose = $_POST['purpose'];

//checkFile
if(isset($_FILES['profileImage']))
{
	$finalName = checkFile($name, $_FILES['profileImage']);
}
else
{
	$finalName = $_POST['profileImage'];
}

$profile = new Profile();
$profile->name = $name;
$profile->desc = $desc;
$profile->achi = $achi;
$profile->img = $finalName;
	
if($purpose == 'add')
{
	$profileAdded = ProfileFactory::addProfile($profile);
	if($profileAdded)
	{
		echo "Profile Added Successfully!";
	}
	else
	{
		echo "Fail To Add Profile";	
	}
}
else if ($purpose == 'edit')
{
	
	$id = $_POST['profileId'];
	$profile->id = $id;
	$profileEditted = ProfileFactory::updateProfile($profile);
	if($profileEditted)
	{
		$profile = ProfileFactory::getProfileById($id);	
		$profile = json_encode($profile);
		print_r($profile);	
	}
	else
	{
		echo "Fail To Edit Profile";	
	}
}


function checkFile($name, $file)
{
	
$msg = true;
$validType = array('image/jpeg', 'image/png', 'image/gif');
	
$type = $file['type'];
$size = $file['size'];
$error = $file['error'];
$tmp_name = $file['tmp_name'];
$imgname = $file['name'];

//check size
if($size > (1024*1024))
{
	$msg = "Invalid File Size";	
}
//check error
if($error != 0)
{
	$msg = "Error";	
}
//check type
foreach($validType as $curType)
{
	if($type == $curType)
	{
		$typeValid = true;	
	}
}
if(!$typeValid)
{
	$msg = "Invalid File Type";	
}

if($msg != true)
{
	header("Location: profiles.php?msg=$msg");
	exit();	
}	


$rand = rand(100,10000);
$foldername = "profiles/";
$imgName = $name."_".$rand;

if($type == 'image/jpeg')
$extension = ".jpeg";
else if($type == 'image/png')
$extension = ".png";
if($type == 'image/gif')
$extension = ".gif";

$finalName = $foldername.$imgName.$extension;


if(move_uploaded_file($tmp_name, $finalName)) return $finalName;
else return false;
}


?>