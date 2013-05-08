<?php
include_once "admin-includes.php";
ob_end_clean();

$toReturn = '';
for($i = 0; $i< count($_FILES['img']['error']); $i++)
{
	$name = $_FILES['img']['name'][$i];
	$tmpName = $_FILES['img']['tmp_name'][$i];
	$type = substr($_FILES['img']['type'][$i], 0, 5);
	if($_FILES['img']['error'][$i] == 0 and $_FILES['img']['size'][$i] <= (1024*1024) and $type == 'image')
	{
		$location = "../images/gallery/test/";
		$rand = rand(100,10000);
		$finalName = $location.$rand."_".$name;
		if(move_uploaded_file($tmpName, $finalName))
		{
			echo "";
		}
	}
	
	else
	{
		echo "<p> Fail To Upload: ". $name."</p>";
	}
		
}

?>