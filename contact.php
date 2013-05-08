<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<?php include_once "includes.php" ?>

<script>
$(document).ready(function(){
	
	fadeContent();
	
	$("#emailForm").submit(function(e)
	{
		e.preventDefault();
		
		var contactForm = document.getElementById($(this).attr('id'));
		var name = contactForm.name.value;
		var email = contactForm.email.value;
		var purpose = contactForm.purpose.value;
		var message = contactForm.message.value;
		
		var url = "contact-process.php?name="+name+"&email="+email+"&purpose="+purpose+"&message="+message
		
		var emailStatus = $.ajax(url).done(function(message){ console.log(message) });
		
	});
	
	});
</script>

<title>Contact Us</title>
</head>

<body>

<div id = 'main'>
<?php include_once "header.php" ?>
<div id = 'contentBody'>
<div id = 'pageTitle'>
Contact us
</div><!-- end page title -->

<div class='main-content' id = 'contact'>
<div id = 'contact-information'>

<div class='contact-information-class' style='margin-left: 290px'>
<span>T: </span>+65 9369 0593
</div>

<div class='contact-information-class'>
<span>M: </span>jeremiahang94@gmail.com
</div>

</div>
<form id='emailForm' method='post' action='#'>
<table id='contact-form'>
<tr><td>
<input type='text' name='name' placeholder="Tell Us Your Name"/>
</td></tr>
<tr><td>
<input type='text' name='email' placeholder="Your Email"/>
</td></tr>
<tr><td>
<select name='purpose'>
<option value="1"> Sign Up For Course </option>
<option value="2"> General Enquiries </option>
</select>

<span> How can we help you? </span>
</td></tr>

<tr><td>
<textarea name='message' rows='15' cols='42' placeholder="Your Message">
</textarea>
</td></tr>
<tr><td>

<input type='submit' />
</td></tr>
</table>
</form>


</div>

</div>
</div>

</body>
</html>