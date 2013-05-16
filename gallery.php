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
	
	getAllGallery();
	
	$(".gallery-class").on('click', openGallery);
	$("#white-overlap").on("click", closeGallery);
		
}

function getAllGallery()
{
	startLoadingAnimation();
	var url = "gallery-functions.php";
	var param = "?purpose=get";
	url += param;
	
	$.ajax(
	{
		url: url,
		type: "GET",
		success: function(res)
		{
			displayAllGallery(res);
		}
	});
}

function displayAllGallery(data)
{
	/*
	<div class = 'gallery-class shadow'>
	<img src='images/gallery/gallery1.jpg' />
	</div><!-- end one gallery -->
	*/
	
	data = $.parseJSON(data);
	for(var i = 0; i<data.length; i++)
	{
		var curData = data[i];
		var galleryClass = $("<div>", 
		{
			class: "gallery-class shadow",
			id: curData.name
		});
		
		loadImage(curData, galleryClass);
	}
}

function loadImage(data, galleryClass)
{
	var src;
	var image = $("<img>", {
		onload: function() 
		{
			galleryClass.append(this).appendTo(".main-content").click(openGallery);
		}
	});
		
	if(data.type == 1)
	{	
		var source = "images/gallery/";
		src = source += data.name;
	}
	else if(data.type == 2)
	{
		src = "http://i.ytimg.com/vi/"+ data.name +"/0.jpg"
		image.attr("class", "v");
	}	
	
	
	image.attr("src", src);
	
}

function openGallery(e)
{
	var child = $(this).children('img');
	console.log(child.hasClass("v"));
	if(!child.hasClass("v"))
	{	
		$("#open-gallery-image").show();
		$("#open-gallery-video").hide();
	
		var imgSrc = child.attr('src');
		$("#open-gallery-image img").attr('src', imgSrc);
		$("#open-gallery").fadeIn(200);
	}
	else
	{	
		$("#open-gallery-image").hide();
		$("#open-gallery-video").show();
		
		var vidId = $(this).attr("id");
		var vidSrc = "http://www.youtube.com/embed/"+ vidId +"?rel=0&controls=0&showinfo=0&autoplay=1";
		
		var loadingImg = "<img class='iframeLoader' src='images/ajax-loader.gif' />";
		$("#open-gallery-video").empty().append(loadingImg);
		var iframe = $("<iframe>", {
			width: 640,
			height: 390,
			frameborder: 0,
			onload: function()
			{
				$(".iframeLoader").hide();
			}
			}).appendTo("#open-gallery-video");
		
		$("#open-gallery-video iframe").attr('src', vidSrc);
		$("#open-gallery").fadeIn(200);
	}
	
}

function closeGallery()
{
	$("#open-gallery").fadeOut(200,function(){
		$("#open-gallery-video iframe").attr('src', '');
		});	
	
}


function startLoadingAnimation()
{
	
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
<div id = 'open-gallery-video' >

</div>

</div>


<div id = 'main'>
<?php include_once "header.php" ?>
<div id = 'contentBody'>
<div id = 'pageTitle'>
Fun. Thrilling. Exciting.
</div><!-- end page title -->

<div class='main-content' id = 'gallery'>

</div>

</div><!-- end content body -->
</div><!-- end main -->
</body>
</html>