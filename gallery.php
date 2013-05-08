<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<?php include_once "includes.php" ?>

<script>
$(document).ready(function(){
	
	fadeContent();
	initGallery();
	});
	
function initGallery()
{
	$("#open-gallery").hide();
	//openGallery();
	$(".gallery-class").on('click', openGallery);
	$("#white-overlap").on("click", closeGallery);
		
}

function openGallery(e)
{
	var imgSrc = $(this).children('img').attr('src');
	$("#open-gallery-image img").attr('src', imgSrc);
	$("#open-gallery").fadeIn(200);
}

function closeGallery()
{
	$("#open-gallery").fadeOut(200);	
}
</script>

<title>Gallery</title>
</head>

<body>

<div id = 'open-gallery'>
<div id = 'white-overlap'>
</div>

<div id = 'open-gallery-image' >
<img src='images/gallery/gallery3.jpg' class='shadow'/>
</div>

</div>


<div id = 'main'>
<?php include_once "header.php" ?>
<div id = 'contentBody'>
<div id = 'pageTitle'>
Fun. Thrilling. Exciting.
</div><!-- end page title -->

<div class='main-content' id = 'gallery'>
<div class = 'gallery-class shadow'>
<img src='images/gallery/gallery1.jpg' />
</div><!-- end one gallery -->
<div class = 'gallery-class shadow'>
<img src='images/gallery/gallery2.jpg' />
</div><!-- end one gallery -->
<div class = 'gallery-class shadow'>
<img src='images/gallery/gallery3.jpg' />
</div><!-- end one gallery -->
<div class = 'gallery-class shadow'>
<img src='images/gallery/gallery4.jpg' />
</div><!-- end one gallery -->
<div class = 'gallery-class shadow'>
<img src='images/gallery/gallery5.jpg' />
</div><!-- end one gallery -->
</div>

</div><!-- end content body -->
</div><!-- end main -->
</body>
</html>