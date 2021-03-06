<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php include_once 'includes.php' ?>
<!-- javascript -->
<script type='text/javascript'>

var noOfPic = 5;
var picNo = 3;
$(document).ready(function(){
	
	fadeContent();
	
	setInterval(function()
				{
					nextPicture(picNo)
				}, 5000);
	
});


</script>

<title>SZS</title>
</head>

<body>




<div id ='main'>

<?php include_once "header.php"; ?>

<div class='main-content' id ='contentBody'>

<div id = 'introContainer' class='section'>
<div id ='introText'>
<p class='introTitle'>Learn A Skill, Save A Life</p>
SZS is an organisation of <span style='font-weight: 400; font-style:italic;'>Passionate </span> lifesavers<br />
Join us now to gain skills that would help save your
fellow friends or yourself in any case of emergency

<p>
<div class='introButton'>Join <span style='font-weight: 400; font-style:italic;'> SZS </span> today! </div>
<div class='introButton' style='background-color: #65C7FD; padding-left: 25px; padding-right: 25px;'>Contact Us </div>
</p>

</div><!-- end intro Text -->

<div id = 'introImageContainer'>
<div class='introImage shadow' id='currentImage'>
<img src='images/intro-pictures/intro1.jpg' />
</div>

<div class='introImage shadow' id ='nextImage'>
<img src='images/intro-pictures/intro2.jpg'/>
</div>

</div><!-- end image -->

</div><!-- end intro Outer-->

<div id = 'stepsToRegister' class='section'>
<div id = 'pageTitle'> Learn From Us </div>
<div class = 'stepClass'>
<img src='images/instruction/step1.png' width='70'/>

<div class = 'stepText' id='step1'>
<p class='stepTitle'> Choose Your Course </p>
<p class='stepDescription'> Choose one of the course from the many choices</p>
</div>

</div>
<div class = 'stepClass'>
<img src='images/instruction/step2.png' width='70'/>

<div class = 'stepText' id='step2'>
<p class='stepTitle'> Prefered Time Slot </p>
<p class='stepDescription'> Let us know which is your prefered time slot</p>
</div>

</div>
<div class = 'stepClass' style='margin-right: 0px'>
<img src='images/instruction/step3.png' width='70'/>

<div class = 'stepText' id='step3'>
<p class='stepTitle'> Register/Contact Us </p>
<p class='stepDescription'> Go to the Register page now to be part of us!</p>
</div>
</div>
</div><!-- end stepsToRegister -->

<div id = 'members' class='section'>

<div id = 'pageTitle'> Members Corner </div>

<div id ='member-class-container'>

<a href='contact.php'>
<div class = 'member-class askAbout'>
<p>
About<br/> 
Members
</p>
</div>
</a>

<a href='friends/alphaalignment.php'>
<div class = 'member-class'>
<p>
Alpha Alignment
</p>
</div>
</a>
</div><!-- ed member class container -->

</div><!-- end members -->

</div><!-- end body -->

<?php include_once "footer.php" ?>

</div>

</body>
</html>