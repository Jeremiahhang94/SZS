<?php
include_once "admin-includes.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Untitled Document</title>
<script>

var filesToUpload = new Array();
var images = new Array();
var formdata;

window.onload = function()
{
	if(window.FormData)
	{
		formdata = new FormData();
		//document.getElementById("submitBnt").style.display = "none";
	}	
	
	if (window.File && window.FileList && window.FileReader) 
	{
		initDragDrop();
	}	
	
	checkSubmitBtn();
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
				appendImage(e.target.result);
			}
		
			reader.readAsDataURL(curFile);
			images.push(curFile);
		}		
	}
	
	checkSubmitBtn();
	
	
}

function appendImage( src )
{
	var div = document.createElement("div");
	div.className = 'gallery-class shadow';
	var img = document.createElement("img");
	img.width = 180;
	img.src = src;
	div.appendChild(img);
	
	$("#gallery-img-preview").append(div);
	
		
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
	startUploading();
	var url = "gallery-add-process.php";
	for(var i = 0; i<images.length; i++)
	{
		formdata.append('img[]', images[i]);
	}
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

function startUploading()
{
	var loader = document.createElement('img');
	loader.src = '../images/ajax-loader.gif';
	loader.style.marginTop = "40px";
	var message = document.createElement('p');
	message.innerHTML = "Uploading Image(s)";
	$("#gallery-img-preview").empty().append(loader, message);	
}
function endUploading(respond)
{
	var message = document.createElement('p');
	message.innerHTML = "Uploaded "+images.length+" Photos";
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
		
}
</script>

</head>

<body>

<div id = 'main'>
<?php  include_once 'admin-header.php'; ?>
<div id = 'content'>

<div id = 'page-title'> Gallery </div>

<div class='gallery-side' id = 'gallery-images' style='border-right: #AAA dotted 1px;'>

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

</div>

</div>

<div class='gallery-side' id = 'gallery-videos'>

<div id = 'gallery-youtube-uploader'>
<form name='youtubeUploadForm' action = '' method='post' onsubmit='return addYoutube()'>
<input type='text' name='youtube' placeholder='Insert link'/><input type='text' name='youtube' placeholder='Insert link'/><input type='text' name='youtube' placeholder='Insert link'/>
</form>

<button style='float: right; margin-right: 90px;' onclick='addVideoField()'> Add Another </button>
</div>

</div>

</div><!-- end content -->
</div>

</body>
</html>