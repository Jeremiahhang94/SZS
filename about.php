<?php 
include_once 'includes.php';

$allProfiles = ProfileFactory::getAllProfile();


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>About Us : SZS</title>

<script>
$(document).ready(function(){
	
	fadeContent();
	
	});
</script>

</head>

<body>
<div id ='main'>
<?php include_once 'header.php' ?>

<div id ='contentBody'>
<div id = 'pageTitle'>
Young. Experienced. Passionate.
</div><!-- end title -->

<div class='main-content' id = 'about'>

<?php
foreach($allProfiles as $profile)
{
?>
<div class='about-class'>
<div class='about-image shadow'>
<img src='admin/<?php echo $profile->img ?>'  />
</div>
<div class='about-text'>
<p class = 'about-name'>
<?php echo $profile->name ?>
</p>
<p><?php echo $profile->desc ?></p>

<p><?php echo $profile->achi ?></p>
</div>
</div><!-- end about class -->
<?php
}
?>


</div><!-- end about -->

</div>

</div><!-- end main -->
</body>
</html>