<?php
function connect()
{
	$connect = mysqli_connect('localhost', 'root', 'root', 'szss');
	if(!$connect)
	{
		echo "error";
		exit();	
	}
	
	return $connect;
	
}

function getAllUser()
{
	$query = "SELECT * FROM user";
	$answer = mysqli_query(connect(), $query);
	
	$userArray = array();
	if(!$answer)
	{
		return 	$userArray;
	}
	
	while($curUser = mysqli_fetch_assoc($answer))
	{
		$user = new User();	
		$user->username = $curUser['username'];
		$user->password = $curUser['password'];
		$user->type = $curUser['type'];
		
		$userArray[] = $user;
	}
	
	return $userArray;
}

function getUserById($username)
{
	echo "hello";
	$query = "SELECT * FROM user WHERE username = '$username'";
	$answer = mysqli_query(connect(), $query);
	
	$user = new User();
	if(!$answer)
	{
			$user->username = 0;
			return $user;
	}
	
	$curUser = mysqli_fetch_assoc($answer);
	$user->username = $curUser['username'];
	$user->password = $curUser['password'];
	$user->type = $curUser['type'];
	
	return $user;

}

?>