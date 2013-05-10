<?php
include_once "admin-includes.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>SZSS : Gallery</title>
<script>

var filesToUpload = new Array();
var images = new Array();
var formdata, videoFormdata;
var videoIdArray = new Array();

window.onload = function()
{
	init();
}

function init()
{
	if(window.FormData)
	{
		formdata = new FormData();
		videoFormdata = new FormData();
		//document.getElementById("submitBnt").style.display = "none";
	}	
	
	if (window.File && window.FileList && window.FileReader) 
	{
		initDragDrop();
	}	
	
	checkSubmitBtn();
	$("#gallery-youtube-add-another").click(addVideoField);
	$("#gallery-youtube-submit").hide();
	$(".galleryYoutubeInput").on("change", checkYoutubeInput);
	
	loadGallery();
}

function loadGallery()
{
	startLoadingAnimation("gallery-display-images");
	getAllGalleryByType(1);
		
}

function initDragDrop()
{
	var fileForm = document.getElementById("galleryUploadForm");
	var fileDrag = document.getElementById("file-drag-area");	
	
	fileDrag.addEventListener("dragover", fileDragHover, false);
	fileDrag.addEventListener("dragleave", fileDragHover, false);
	fileDrag.addEventListener("drop", fileSelectHandler, false);
	
}

function fileDragHover(e)
{
	e.stopPropagation();
	e.preventDefault();	
	e.target.className = (e.type == "dragover" ? "hover" : "");
	
	if(e.type == "dragover")
	e.target.innerHTML = "Yup! Drop here";
	else
	e.target.innerHTML = "Drag Photos Here";
}
function fileSelectHandler(e)
{
	fileDragHover(e);
	e.target.innerHTML = "Drag Photos Here";
	
	e.stopPropagation();
	e.preventDefault();
		
	var input = e.dataTransfer;
	
	photoChange(input);
}

function photoChange(input)
{
	for(var i = 0; i<input.files.length; i++)
	{
		var curFile = input.files[i];
		var fileExist = false;
		for(var j = 0; j<images.length; j++)
		{
			if(images[j].name == curFile.name)
			{
				//file selected already
				alert("One of the file already exist");
				fileExist = true;
			}
		}
		
		if(!fileExist && checkFile(curFile) && curFile)
		{
			var reader = new FileReader();
			
			reader.onload = function(e)
			{	
				appendImage("gallery-img-preview", e.target.result);
			}
		
			reader.readAsDataURL(curFile);
			images.push(curFile);
		}		
	}
	
	checkSubmitBtn();
	
	
}

function appendImage( target, src )
{
	var div = document.createElement("div");
	div.className = 'gallery-class shadow';
	var img = document.createElement("img");
	img.width = 180;
	img.src = src;
	div.appendChild(img);
	
	$("#"+target).append(div);
	
		
}

function checkFile(file)
{
	/*
	taken from profiles.php
	*/
	var typeValid = false;
	var sizeValid = false;
	
	var type = file.type;
	var size = file.size;
	
	var validTypes = [ 'image/jpeg', 'image/png', 'image/gif' ];
	for(var i = 0; i < validTypes.length; i++)
	{
		if(type == validTypes[i])
		typeValid = true;
	}
	if (size < (1024*1024))
	{
		sizeValid = true;	
	}
	
	if(!(sizeValid && typeValid))
	{
		alert("Invalid File!");
		return false;	
	}	
	
	else return true;
}


function submitImages()
{
	startLoadingAnimation("gallery-img-preview");
	var url = "gallery-add-process.php";
	for(var i = 0; i<images.length; i++)
	{
		formdata.append('img[]', images[i]);
	}
	formdata.append('purpose', "picture");
	$.ajax({
		type:"POST",
		data:formdata,
		url:url,
        processData: false,  
        contentType: false,
		success: function(respond)
		{
			if(respond == '')	
			endUploading(respond);
		}
	
	});
	return false;	
}

function startLoaingAnimation(target)
{
	var loader = document.createElement('img');
	loader.src = '../images/ajax-loader.gif';
	loader.style.marginTop = "40px";
	var message = document.createElement('p');
	message.innerHTML = "Uploading Image(s)";
	$("#"+target).empty().append(loader, message);	
}
function endUploading(respond)
{
	var message = document.createElement('p');
	message.innerHTML = "Uploaded "+images.length+" Photos";
	message.style.fontStyle = 'italic';
	message.style.fontWeight = 400;
	$("#gallery-img-preview").empty().append(message);	
	
	images = new Array();
	checkSubmitBtn();
}

function checkSubmitBtn()
{
	if(images.length != 0)
	{
		$("#submitImages").show();
	}
	else
	{
		$("#submitImages").hide();
	}
}	

function addVideoField()
{
	var toAppend = "<p><input type='text' name='youtube' class='galleryYoutubeInput' placeholder='Insert Youtube link'/></p>"
	$("#youtubeUploadForm").append(toAppend);
}
function resetVideoField()
{
	var toAppend = "<p><input type='text' name='youtube' class='galleryYoutubeInput' placeholder='Insert Youtube link'/></p><p><input type='text' name='youtube' class='galleryYoutubeInput' placeholder='Insert Youtube link'/></p><p><input type='text' name='youtube' class='galleryYoutubeInput' placeholder='Insert Youtube link'/></p>"
	$("#youtubeUploadForm").empty().append(toAppend);
}

function checkYoutubeInput(e)
{
	var input = e.target.value;
	if(input.match("yout"))
	{
		var videoId = getYoutubeId(input);
		var url = "http://gdata.youtube.com/feeds/api/videos/" + videoId;
		$.ajax(
		{
			url: url,
			type: "get",
			complete: function(res)
			{
				if(res.status == '200')
				{
					e.target.className = 'galleryYoutubeInput linkOk';
					checkYoutubeForm();
				}
				else if(res.status == '400')
				{
					e.target.className = 'galleryYoutubeInput linkError';
				}
			}
		});
	}
	else
	{
		e.target.className = 'galleryYoutubeInput linkError';
	}
	
	checkYoutubeForm();
	
	
}

function getYoutubeId(url)
{
	var re = /https?:\/\/(?:[0-9A-Z-]+\.)?(?:youtu\.be\/|youtube\.com\S*[^\w\-\s])([\w\-]{11})(?=[^\w\-]|$)(?![?=&+%\w]*(?:['"][^<>]*>|<\/a>))[?=&+%\w-]*/ig;
    return url.replace(re, '$1');	
}

function checkYoutubeForm()
{
	if($(".linkOk").length > 0)
	{
		$("#gallery-youtube-submit").show();
	}
	
}

function addYoutube()
{
	if(confirm("Add "+$(".linkOk").length +" Video(s)?"))
	{
		var toAdd = $(".linkOk").length;
		$(".linkOk").each(function()
			{
				var videoId = getYoutubeId($(this).val());
				videoIdArray.push(videoId);
			});
			
		videoFormdata.append("videoId", videoIdArray);
		videoFormdata.append('purpose', "video");
		var url = "gallery-add-process.php";
		$.ajax(
		{
			url: url,
			type: "post",
			data: videoFormdata,
    	    processData: false,  
    	    contentType: false,
			success: function(res)
			{
				if(res == 'Added')
				{
					videoFormData = new FormData();
					videoIdArray = new Array();
					resetVideoField();
					var msg = "<p style='font-weight: 400; font-style: italic'>"+ toAdd+" video(s) added <p>";
					$("#youtubeUploadForm").prepend(msg);
				}
			}
		});
	}
}

function getAllGalleryByType(type)
{
	var url = "gallery-functions.php";
	var param = "?purpose=get&id=&type="+type;
	url += param;
	
	$.ajax(
	{
		type: "GET",
		url: url,
		success: function(res)
		{
			if(res != 0)
			{
				res = $.parseJSON(res);
				for(var i =0; i<res.length; i++)
				{
					var path = "../images/gallery/";
					var src = path + res[i].name;	
					var target = "gallery-display-images";
					appendImage( target, src );
				}
			}
			else
			{
				console.log("nothing");	
			}
		}
			
	});
}

function startGalleryLoading()
{
}

</script>

</head>

<body>

<div id = 'main'>
<?php  include_once 'admin-header.php'; ?>
<div id = 'content'>

<div id = 'page-title'> Gallery </div>

<div class='gallery-side' id = 'gallery-images' style='border-right: #AAA dotted 1px;'>

<div id='gallery-display-images'>
<div class='gallery-class shadow'></div>
<div class='gallery-class shadow'></div>
</div><!-- end display images -->

<div id = 'add-image-form-preview'>

<form id='galleryUploadForm' action='' method='post' onsubmit='return addPhoto()' enctype="multipart/form-data">
<input type='file' name='imgs' multiple="multiple" onchange='photoChange(this)' />
</form>

<div id = 'file-drag-area'>
Drag Photos Here
</div>


<div id = 'gallery-img-preview'>

</div>

<button id='submitImages' onclick='return submitImages()'> Confirm Upload Images </button>

</div><!-- end add image -->

</div>

<div class='gallery-side' id = 'gallery-videos'>

<div id = 'gallery-youtube-uploader'>
<form 
id='youtubeUploadForm' 
name='youtubeUploadForm' 
action = '' method='post' 
onsubmit='return addYoutube()'>

<p><input type='text' name='youtube' class='galleryYoutubeInput' placeholder='Insert Youtube link'/></p>
<p><input type='text' name='youtube' class='galleryYoutubeInput' placeholder='Insert Youtube link'/></p>
<p><input type='text' name='youtube' class='galleryYoutubeInput' placeholder='Insert Youtube link'/></p>

</form>

<div id = 'gallery-youtube-add-another'> Add Another </div>
<p><button id='gallery-youtube-submit' onclick='addYoutube()'>Confirm Upload Youtubes</button></p>
</div>

</div>

</div><!-- end content -->
</div>

</body>
</html>