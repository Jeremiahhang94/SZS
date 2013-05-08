<?php
include_once 'admin-includes.php';
ob_end_clean();

$courses = CourseFactory::getAllCourse();
$courses = json_encode($courses);
print_r($courses);

?>