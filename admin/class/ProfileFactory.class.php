<?php
class ProfileFactory
{
	public static function getAllProfile()
	{
		$query = "SELECT * FROM profiles";
		$answer = mysqli_query(Connect::getConnection(), $query);
		if(!$answer) return false;
		
		$profiles = array();
		while($curProfile = mysqli_fetch_assoc($answer))
		{
			$profile = new Profile();
			$profile->id = $curProfile['id'];
			$profile->name = $curProfile['name'];
			$profile->desc = $curProfile['description'];
			$profile->achi = $curProfile['achievement'];
			$profile->img = $curProfile['img'];
			$profiles[] = $profile;	
		}
		
		return $profiles;
	}
	
	public static function addProfile($profile)
	{
		$query = "INSERT INTO profiles VALUES (NULL, '$profile->name', '$profile->desc', '$profile->achi', '$profile->img')";	
		$answer = mysqli_query(Connect::getConnection(), $query);
		if(!$answer) return false;
		
		return "added";
	}
	
	public static function getProfileById($id)
	{
		$query = "SELECT * FROM profiles WHERE id = $id";
		$answer = mysqli_query(Connect::getConnection(), $query);
		if(!$answer) return false;
		
		$fetchProfile = mysqli_fetch_assoc($answer);
		$profile = new Profile();
		$profile-> id = $fetchProfile['id'];
		$profile-> name = $fetchProfile['name'];
		$profile-> desc = $fetchProfile['description'];
		$profile-> achi = $fetchProfile['achievement'];
		$profile-> img = $fetchProfile['img'];
		
		return $profile;
	}
	
	public static function deleteProfileById($id)
	{
		$img = ProfileFactory::getProfileById($id)->img;
		if(!unlink($img)) return false;
		
		$query = "DELETE FROM profiles WHERE id = $id";
		$answer = mysqli_query(Connect::getConnection(), $query);
		if(!$answer)return false;
		
		return true;	
	}
	
	public static function updateProfile($profile)
	{
		$img = ProfileFactory::getProfileById($profile->id)->img;
		if($img != $profile->img)
		{
			if(!unlink($img))
			{
				return false;	
			}
		}
		
		$query = "UPDATE profiles SET name='$profile->name', description='$profile->desc', achievement='$profile->achi', img='$profile->img' WHERE id = $profile->id";	
		$answer = mysqli_query(Connect::getConnection(), $query);
		if(!$answer) return $query;
		
		return true;
		
	}
}

?>