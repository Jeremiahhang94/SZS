<?php
class AnnouncementFactory
{
	
	public static function getAllAnnouncement()
	{
		$query = "SELECT * FROM announcement ORDER BY 1 DESC";
		$answer = mysqli_query(Connect::getConnection(), $query);
		if(!$answer) return false;
		
		$annoArray = array();
		while($curAnno = mysqli_fetch_assoc($answer))
		{
			$anno = new Announcement();
			$anno->id = $curAnno['id'];
			$anno->text = $curAnno['text'];
			$anno->show = $curAnno['show'];
			$annoArray[] = $anno;	
		}
		
		return $annoArray;
			
	}
	
	public static function getAnnouncementById($id)
	{
		$query = "SELECT * FROM announcement WHERE id = $id";
		$answer = mysqli_query(Connect::getConnection(), $query);
		if(!$answer) return false;
		
		$curAnno = mysqli_fetch_assoc($answer);
		$anno = new Announcement();
		$anno->id = $curAnno['id'];
		$anno->text = $curAnno['text'];
		$anno->show = $curAnno['show'];
		
		return $anno;
	}
	
	public static function toggleAnnouncementShow($id)
	{
		$anno = AnnouncementFactory::getAnnouncementById($id);
		if($anno->show == 0)
		{
			$anno->show = 1;	
		}
		else if($anno->show == 1)
		{
			$anno->show = 0;	
		}
		
		$query = "UPDATE announcement SET announcement.show = $anno->show WHERE id = $id";
		$answer = mysqli_query(Connect::getConnection(), $query);
		if(!$answer) return false;
		
		else return true;
	}
	
	public static function addAnnouncement($anno)
	{
		$query = "INSERT INTO announcement VALUES (NULL, '$anno->text', $anno->show)";
		$answer = mysqli_query(Connect::getConnection(), $query);
		if(!$answer) return false;
		
		else return true;	
	}
	
	public static function deleteAnnouncement($id)
	{
		$query = "DELETE FROM announcement WHERE id = $id";
		$answer = mysqli_query(Connect::getConnection(), $query);
		if(!$answer) echo $query;
		
		else return true;	
	}
	
	public static function updateAnnouncement($anno)
	{
		$query = "UPDATE announcement SET announcement.text = '$anno->text' WHERE id = $anno->id";
		$answer = mysqli_query(Connect::getConnection(), $query);
		if(!$answer) return false;
		
		else return true;
	}
}

?>