<?php
include_once 'class/connect.class.php';
include_once 'class/user.php';
include_once 'class/courseFactory.class.php';
include_once 'class/course.class.php';
include_once 'class/Profile.class.php';
include_once 'class/ProfileFactory.class.php';

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 'On');

include_once 'functions.php';


ob_start();
?>

<!-- google fonts -->
<link href='http://fonts.googleapis.com/css?family=Roboto:400,400italic,100,300,300italic' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Gilda+Display' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Alike' rel='stylesheet' type='text/css'>

<!-- css -->
<link href="admin-main.css" rel="stylesheet" type="text/css" />

<!-- script -->
<script src='../jquery-1.9.1.min.js'></script>