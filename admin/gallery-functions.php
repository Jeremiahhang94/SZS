<?php
include_once "admin-includes.php";
ob_end_clean();

$p = $_GET['purpose'];
$id = $_GET['id'];

if($p == "get")
{
	$allGalleryOfType = GalleryFactory::getAllGalleryByType($_GET['type']);	
	if($allGalleryOfType)
	{
		$allGalleryOfType = json_encode($allGalleryOfType);
		print_r($allGalleryOfType);
	}
	else
	{
		echo "0";	
	}
}
?>