<?php
/*
created: 18/4 1313 Jeremiah 
last edited 18/4 1313 Jeremiah

purpose: connection class

*/
class Connect
{
	public static function getConnection()
	{
		$server = "localhost";
		$username = "root";
		$password = "root";
		$database = "szss";
		
		$connection = mysqli_connect($server,$username,$password,$database);
		if(!$connection)
		{
			$connection = false;	
		}
		
		return $connection;	
		
	}
}


?>