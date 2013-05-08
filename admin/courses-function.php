<?php
include_once 'admin-includes.php';
ob_end_clean();

$id = $_GET['id'];
$p = $_GET['p'];

if($p == 'get')
$course = CourseFactory::getCourseById($id);

if($p == 'delete')
{
$courseDelete = CourseFactory::deleteCourseById($id);
echo $courseDelete;
}

?>