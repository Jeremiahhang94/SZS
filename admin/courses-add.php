<?php
include_once 'admin-includes.php';
ob_end_clean();

$course = new Course();

foreach($_GET as $key=>$value)
{
	$course->$key = $value;
}

$courseAdded = CourseFactory::addCourse($course);
if($courseAdded)
{
	$course = CourseFactory::getCourseById($courseAdded);	
}
else
{
	echo "Fail";	
}


?>