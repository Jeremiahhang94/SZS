<?php
include_once 'includes.php';
ob_end_clean();

$p = $_GET['purpose'];

if($p == 'get')
{
	$allGallery = GalleryFactory::getAllGallery();
	if(!$allGallery)
	{
		echo "0";	
	}
	else
	{
		print_r(json_encode($allGallery));	
	}
		
}
?>