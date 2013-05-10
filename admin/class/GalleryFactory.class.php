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
	
	public static function getGalleryById($id)
	{
		$query = "SELECT * FROM gallery WHERE id = $id";
		$answer = mysqli_query(Connect::getConnection(), $query);
		if(!$answer) return false;
		
		$curGallery = mysqli_fetch_assoc($answer);
		$gallery = new Gallery();
		$gallery->id = $curGallery['id'];	
		$gallery->name = $curGallery['name'];	
		$gallery->type = $curGallery['type'];
		
		return $gallery;
	}
	
	public static function deleteGallery($id)
	{
		$path = "../images/gallery/";
		if(!unlink($path.GalleryFactory::getGalleryById($id)->name)) return false;	
		
		$query = "DELETE FROM gallery WHERE id = $id";
		$answer = mysqli_query(Connect::getConnection(), $query);
		if(!$answer) return false;
		
		else return "Deleted";
	}
}

?>