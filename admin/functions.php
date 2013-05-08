<?php
function isLoggedIn()
{
	if(!isset($_SESSION['user']))
	{
		header("Location: login.php");	
		exit();
	}
}

function getAllUser()
{
	$query = "SELECT * FROM user";
	$answer = mysqli_query(Connect::getConnection(), $query);
	
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
	
	$query = "SELECT * FROM user WHERE username = '$username'";
	$answer = mysqli_query(Connect::getConnection(), $query);
	
	$user = new User();	
	if(!$answer)
	{
		$user->username = "Invalid";
		return $user;	
	}
	
	$curUser = mysqli_fetch_assoc($answer);
	$user->username = $curUser['username'];
	$user->password = $curUser['password'];
	$user->type = $curUser['type'];
	
	return $user;

}



?>