<?php
/*
created: 20/4 1329 jeremiah
edited: 20/4 1329 jeremiah

purpose: to recieve all ajax information from courses.php

*/
include_once 'includes.php';
ob_end_clean();

$purpose = $_GET['p'];

if($purpose == 'ls')
{
	//get all ls course
	$certType = 0;
	$imgSrc = 'images/lifesaving-tri.png';
	$certs = CourseFactory::getAllCertByCertType($certType);
	loadCourses($imgSrc, $certs);
	
}

if($purpose == 'ss')
{
	$certType = 1;
	$imgSrc = 'images/swimsafer-dot.png';
	$certs = CourseFactory::getAllCertByCertType($certType);
	loadCourses($imgSrc, $certs);
}

function loadCourses($imgSrc, $certs)
{
	foreach($certs as $currentCert)
	{
		//course title
		$allCourse = CourseFactory::getCourseByCertId($currentCert['id']);
		if(count($allCourse) != 0)
		{
		
			echo "<div class = 'one-course' id='lifesaving'>
				<div class = 'course-title'>
				<img src='$imgSrc' width='25'/> <span> ".$currentCert['cert_name']." </span>
			  	</div>";
				
			generateCourseHTML($allCourse);
			
			echo "</div>";
		}
	}	
}
function generateCourseHTML($allCourse)
{
	//class continer 
	echo "<div class = 'classes-container'>";
	
	foreach($allCourse as $course)
	{
?>
	<div class ='one-class'>
		<div class ='class-name'>
			<?php echo $course->name; ?>
		</div><!-- end class name -->
		<div class ='class-detail'>
			<p> Days: <?php echo $course->getDaysName(); ?> </p>
			<p> Time: <?php echo $course->time; ?> </p>
			<p> Venue: <?php echo $course->getVenueName(); ?> </p>
		</div><!-- end course detail -->
	</div><!-- end one class -->
    
<?php
	}
	
	echo "</div>";
}

?>