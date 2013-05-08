<?php
include_once "admin-includes.php";
ob_end_clean();
$p = $_POST['purpose'];

if($p == 'picture')
{
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
			$dbName = $rand."_".$name;
			$finalName = $location.$dbName;
			if(move_uploaded_file($tmpName, $finalName))
			{
				$gallery = new Gallery();
				$gallery->name = $dbName;
				$gallery->type = 1;
				$galleryAdded = GalleryFactory::addGallery($gallery);
				echo "";
			}
		}
		
		else
		{
			echo "<p> Fail To Upload: ". $name."</p>";
		}
			
	}	
}
else if($p == 'video')
{
	$videos = preg_split('/,/', $_POST['videoId']);
	$error = 0;
	for($i = 0; $i<count($videos); $i++)
	{
		$curVideo = $videos[$i];
		$gallery = new Gallery();
		$gallery->name = $curVideo;
		$gallery->type = 2;
		$galleryAdded = GalleryFactory::addGallery($gallery);
		if(!$galleryAdded)
		{
			$error++;
		}
	}
	
	if($error == 0)
	{
		echo "Added";	
	}
	
}

?>