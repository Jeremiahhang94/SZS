<?php
$noNeedCheck = true;
include_once "admin-includes.php";
/*
created: 17/4 1759 Jeremiah 
last edited 17/4 1759 Jeremiah

purpose: validate user login

*/

//get login values
$username = $_POST['username'];
$password = md5($_POST['password']);

$user = getUserById($username);
if($user->username == 'Invalid' || $password != $user->password)
{
	//no such user
	//or incorrect password
	echo "Username or Password invalid";
	exit();	
}


$_SESSION['user'] = $user;

header("Location: index.php");





?>