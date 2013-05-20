<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<?php include_once "includes.php" ?>
<script type='text/javascript'>

$(document).ready(init);

var courseDetail = '';
var selectedCourse = '';

function init()
{
	$(".courses-step").hide();
	$(".courses-step:first").show();
	loadCourses();
	
	fadeContent();
	$(".one-cert").on('click', loadCert);	
}




function goStepThree()
{
	
	var courseName = selectedCourse;
	var monthForm = document.forms['selectMonthForm'];
	var monthSelect = monthForm.month;
	var month = monthSelect.options[monthSelect.selectedIndex].text.substr(0,3);
	
	var courseId = courseName+"-"+month;
	var signUpForm = document.forms['signUpForm'];
	var info = signUpForm.signUpInfo;
	var content = signUpForm.content;
	info.value = "You are signing up for: " + courseId;
	content.value = "Do You Have Any Questions?"
	content.value += "\n---------- \n----------  \n\n";
	content.value += "<type here> \n";
	
	$("#step3").fadeIn(200);
}

function validate()
{
	var form = document.forms['signUpForm'];
	var name = form.name.value;
	var email = form.email.value;
	
	if(name == '' || email == '')
	{
		alert("Please Fill Up All Fields");	
	}
	
	return false;
}

</script>
<title>Courses : SZS</title>
</head>

<body>
<div id = 'main'>
<?php include_once "header.php" ?>

<div id = 'contentBody'>
<div id = 'pageTitle'>
Join. Learn. Experience.
</div><!-- end title -->

<div class='main-content' id = 'courses'>


<div id = 'course-container'>

<div class='courses-step'>
<div class = 'courses-step-title'>Step 1: Choose Your Course</div>

<div id = 'certs-tabs'>
</div><!-- end tabs -->

</div>

<div class='courses-step' id='step2'>
<div class = 'courses-step-title'>Step 2: Select Start Date</div>

<div id = 'certs-info'>

<div id = 'certs-given-info'>
<div class = 'one-info'><p><span>Pre-Requisites:</span> Must be able to swim at least 200m continuously in breaststoke or freestyle</p></div>
<div class = 'one-info'><p><span>Min. Age:</span> 12 Years Old</p></div>
<div class = 'one-info'><p><span>Fee:</span> $350 inclusive of test fees, booking fee & lifesaving manual</p></div>
<div class = 'one-info'><p><span>Duration:</span> 4 session, 2-3 hours</p> </div>
<div class = 'one-info'><p><span>Lesson:</span> Every Wednesday 6pm</p> </div>
</div>

<div class='certs-select-month'>
<form onsubmit = 'goStepThree(); return false; ' name='selectMonthForm'>
<div class = 'one-info'><p><span>Select Month: </span>
<select name='month' id ='selectMonth'>
<?php
$date = date('n');
for($i = 1; $i <= 12; $i++)
{
	$monthName = date("F", mktime(0, 0, 0, $i, 10));
	
	if($i == $date + 1)
	echo "<option value=$i selected='selected'> $monthName </option>";		
	else
	echo "<option value=$i> $monthName </option>";	
}

?>
</select>

</p></div>

<input type='submit' value='Next Step >>' />
</form>
</div>

</div>



</div>

<div class='courses-step' id='step3'>
<div class = 'courses-step-title'>Step 3: Sign Up!</div>

<div id = 'sign-up-info'>
<form onsubmit = 'return validate()' name='signUpForm' action='#' method='post'>

<input type = 'text' name='name' placeholder='Enter Your Name' />
<input type = 'text' name='email' placeholder='Enter Your Email' />
<input type = 'text' name='signUpInfo' disabled='true'/>
<textarea name='content'>
</textarea>

<input type = 'submit' value='Sign Me Up!' />

</form>
</div>

</div>

</div><!-- end course container -->

</div><!-- end courses -->

</div><!-- end content body -->
<?php include_once "footer.php" ?>
</div><!-- end main --> 
</body>
</html>