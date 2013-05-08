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
	
}

?>