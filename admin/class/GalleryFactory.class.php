<?php
class GalleryFactory
{

	public static function addGallery($gallery)
	{
		$query = "INSERT INTO gallery VALUES(NULL, '$gallery->name', $gallery->type)";
		$answer = mysqli_query(Connect::getConnection(), $query);
		if(!$answer) return false;
		
		else return true;
	}
	
	public static function getAllGalleryByType($type)
	{
		$query = "SELECT * FROM gallery WHERE type = $type";
		$answer = mysqli_query(Connect::getConnection(), $query);
		if(!$answer) return 0;
		
		$galleryArray = array();
		while($curGallery = mysqli_fetch_assoc($answer))
		{
			$gallery = new Gallery();
			$gallery->id = $curGallery['id'];	
			$gallery->name = $curGallery['name'];	
			$gallery->type = $curGallery['type'];	
			
			$galleryArray[] = $gallery;
		}
		
		return $galleryArray;
	}	
	
}

?>