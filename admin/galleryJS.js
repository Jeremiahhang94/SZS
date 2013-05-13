// JavaScript Document

var filesToUpload = new Array();
var images = new Array();
var formdata, videoFormdata;
var videoIdArray = new Array();

var imgDiv = "gallery-display-images";
var vidDiv = "gallery-display-videos";
var generatedImgDiv = "gallery-display-images-generated";
var addImgFormDiv = "add-image-form-preview";

var generatedVideoDiv = "gallery-display-videos-generated";

var showcase;
var showcaseId;

var ytPlayer;
var nextPrevType;

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
	$("#gallery-add-images-btn").click(showAddImageForm);
	$("#gallery-add-videos-btn").click(showAddVideoForm);
	$("#gallery-youtube-add-another").click(addVideoField);
	$(".galleryYoutubeInput").on("change", checkYoutubeInput);
	$("#"+addImgFormDiv, "#gallery-youtube-submit", "#"+imgDiv).hide();
	$("#gallery-youtube-uploader").hide();
	
	var player = document.createElement("div");
	player.id = player;
	
	loadGallery(1);
	loadGallery(2);
}


function startLoadingAnimation(target, msg)
{
	var loader = document.createElement('img');
	loader.src = '../images/ajax-loader.gif';
	loader.style.marginTop = "40px";
	var message = document.createElement('p');
	message.innerHTML = msg;
	$("#"+target).empty().append(loader, message);	
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
				if(type == 1)
				{
					var target = generatedImgDiv;
					var path = "../images/gallery/";
				
					//reset gallery
					$("#"+target).empty();
				
					res = $.parseJSON(res);
					for(var i =0; i<res.length; i++)
					{
						var src = path + res[i].name;
						var id = res[i].id;	
						appendImage( target, src, id);
					}	
				} // type == 1
				else if (type == 2)
				{
					$("#"+generatedVideoDiv).empty();
					
					var allVideo = $.parseJSON(res);
					for(var i = 0; i<allVideo.length; i++)
					{
						getVideoInformation(allVideo[i]);
					}
					
				}
				
			}
			else
			{
				console.log("nothing");	
			}
		}
			
	}).done(showGallery);
}

function loadGallery(type)
{
	if(type == 1)
	startLoadingAnimation(generatedImgDiv, "Loading...");
	else if(type == 2)
	startLoadingAnimation(generatedVideoDiv, "Loading...");
	
	getAllGalleryByType(type); //get gallery by type
		
}

/* =========================== =========================== ===========================   */
										/* IMAGES */
/* =========================== =========================== ===========================   */
function showAddImageForm()
{
	$("#"+imgDiv).fadeOut(200, function(){
			$("#"+addImgFormDiv).fadeIn(200);
		});
}
function showGallery()
{
	$("#"+addImgFormDiv).fadeOut(200, function(){
			$("#"+imgDiv).fadeIn(200);
		});
		
	$(".gallery-class-image").unbind("click").click(getSelectedImgInfo);
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
				appendImage("gallery-img-preview", e.target.result, '');
			}
		
			reader.readAsDataURL(curFile);
			images.push(curFile);
		}		
	}
	
	checkSubmitBtn();
	
	
}

function appendImage( target, src, id )
{
	var div = document.createElement("div");
	div.className = 'gallery-class shadow';
	div.id = id;
	var img = document.createElement("img");
	img.className = 'gallery-class-image';
	img.height = 180;
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
	startLoadingAnimation("gallery-img-preview", "Uploading Image(s)");
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
			endUploadingImg(respond);
		}
	
	});
	return false;	
}
function endUploadingImg(respond)
{
	var message = document.createElement('p');
	message.innerHTML = "Uploaded "+images.length+" Photo(s)";
	message.style.fontStyle = 'italic';
	message.style.fontWeight = 400;
	$("#"+imgDiv).prepend(message);	
	
	images = new Array();
	checkSubmitBtn();
	
	loadGallery(1);
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
/* end images */

/* =========================== =========================== ===========================   */
										/* VIDEOS */
/* =========================== =========================== ===========================   */

function showAddVideoForm()
{
	$("#"+ vidDiv).fadeOut(200, function()
	{
		$("#gallery-youtube-uploader").fadeIn(200);	
	});
}
function getVideoInformation(vid)
{	
	var name = vid.name;
	var id = vid.id;
	
	var url = "http://gdata.youtube.com/feeds/api/videos/" + name+"?alt=json";
	$.get(
	url,
	function(respond)
	{
		var title = respond.entry.title.$t;
		var image = respond.entry.media$group.media$thumbnail[0].url;
		appendVideo(id, name, title, image);
	}
	);

}

function appendVideo(id, name, title, src)
{
	var div = document.createElement("div");
	div.className = 'gallery-class shadow';
	div.id = id;
	div.label = name;
	var img = document.createElement("img");
	img.src= src;
	img.className = 'gallery-class-video';
	
	var imgRatio = img.width / img.height;
	img.height = 180;
	img.width =  imgRatio * img.height;
	var offset = (img.width - 180)/2;
	img.style.marginLeft = offset * -1;
	
	div.appendChild(img);
	document.getElementById(generatedVideoDiv).appendChild(div);
	
	
	$(".gallery-class-video").unbind("click").click(prepareVideoForStage);
		
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
		}).done(function(){
			$("#gallery-youtube-uploader").fadeOut(200, function()
				{
					$("#"+ vidDiv).fadeIn(200);	
				});
			loadGallery(2);
			});
	}
}



/* =========================== =========================== ===========================   */
									  /* SHOWCASE */
/* =========================== =========================== ===========================   */

function Showcase(id)
{
	var givenId = "showcase";
	$("#"+id).attr("id", givenId);
	showcaseId = givenId;
	
	var showcaseHolder = document.getElementById(showcaseId);
	var stage = document.createElement("div");
	stage.id = 'showcase-stage';
	stage.className = 'shadow';
	initShowcaseStage(stage);
	
	showcaseHolder.appendChild(stage);
	
	$("#"+showcaseId).hide();
	
	
}

function initShowcaseStage(stage)
{		
	
	var stageController = document.createElement("div");
	stageController.id = 'stageController';
	
	var closeBtn = document.createElement("div");
	closeBtn.id = 'showcase-stage-option-close'
	closeBtn.innerHTML = 'X Close';
	closeBtn.onclick = closeGallery;
	
	var nextBtn = document.createElement("div");
	nextBtn.className = 'stage-control';
	nextBtn.innerHTML = ">";
	nextBtn.id = "showcase-stage-option-next";
	var prevBtn = document.createElement("div");
	prevBtn.className = 'stage-control';
	prevBtn.innerHTML = "<"
	prevBtn.id = "showcase-stage-option-prev";
	
	var deleteBtn = new Image();
	deleteBtn.id = "showcase-stage-option-delete";
	deleteBtn.src = "../images/showcase-delete.png";
	deleteBtn.width = 20;
	deleteBtn.height = 20;
	deleteBtn.addEventListener("click", deleteBtnClicked);
	
	nextBtn.addEventListener("click", prevNextClicked);
	prevBtn.addEventListener("click", prevNextClicked);
	
	stageController.appendChild(closeBtn);
	stageController.appendChild(prevBtn);
	stageController.appendChild(nextBtn);
	stageController.appendChild(deleteBtn);
	
	stageController.hidden = true;
	
	stage.addEventListener("mouseover", triggerStageOptions);
	stage.addEventListener("mouseout", triggerStageOptions);
	
	var stageItem = document.createElement("div");
	stageItem.id = 'showcase-stage-item';
	stageItem.hidden = true;
	
	stage.appendChild(stageController);
	stage.appendChild(stageItem);
	
}

function getSelectedImgInfo(e)
{
	e.stopPropagation();
	e.preventDefault();
	
	var id = $(this).parent().attr('id');
	
	var imgSrc = $(this).attr("src");
	
	
	openGallery(id, imgSrc, 1);
}	

function prepareVideoForStage()
{
	var id = $(this).parent().attr('id');
	vidid = document.getElementById(id).label;
	ytPlayer = '<iframe width="640" height="390" src="http://www.youtube.com/embed/'+vidid+'?rel=0&controls=0&showinfo=0&autoplay=1" frameborder="0"></iframe>'
	openGallery(id, 0, 2);
}

function openGallery(id, imgSrc, type)
{
	$("#showcase-stage-item").fadeOut(200, function(){ $(this).empty(); });
	
	var id = id;
	var nextId =  $("#"+id).next().attr('id');
	var prevId =  $("#"+id).prev().attr('id');
	
	console.log($("#"+id).next());
	
	nextPrevType = type;
	
	var ids = 
	{
		img: id,
		next: nextId,
		prev: prevId
	};
	
	if(type == 1)
	{
		//images
		var img = loadImage(imgSrc);
		$("#showcase-stage").animate({width: img.width}, 400, function(){
				$(this).animate({height: img.height}, 400, function()
				{
					$("#showcase-stage-item").append(img).fadeIn(300);
				});
			});
			
	
		$("#"+ showcaseId).fadeIn(200);
	}
	
	else if(type == 2)
	{
		//videos
	  
		$("#showcase-stage").animate({width: 640}, 400, function(){
				$(this).animate({height: 390}, 400, function()
				{
					$("#showcase-stage-item").append(ytPlayer).fadeIn(300);
				});
			});	
		$("#"+ showcaseId).fadeIn(200);
	}
	
	var nextBtn = document.getElementById("showcase-stage-option-next");
	var prevBtn = document.getElementById("showcase-stage-option-prev");
	var deleteBtn = document.getElementById("showcase-stage-option-delete");
		
	if(img == undefined)
	var btnheight = 390 / 2.6;
	else 
	var btnheight = img.height / 2.6;
	
	nextBtn.style.marginTop = btnheight;
	prevBtn.style.marginTop = btnheight;
	nextBtn.label = ids.next;
	prevBtn.label = ids.prev;
	deleteBtn.label = ids.img;
}

function loadImage(src)
{
	var maxWidth = (window.innerWidth || document.body.clientWidth) * 0.8;
	var maxHeight = (window.innerHeight || document.body.clientHeight) * 0.7;
	
	var img = new Image();
	img.src = src;
	
	imgRatio = img.width / img.height;
	
	if(img.height > maxHeight)
	{
		img.height = maxHeight;	
		img.width = imgRatio * img.height;
	}
	
	if(img.complete) return img;
}
function closeGallery()
{
	$("#"+showcaseId).fadeOut(200, function(){
		$("#showcase-stage").width(0).height(0);
		$("#showcase-stage-item").fadeOut(200, function(){ $(this).empty(); });
		});
		
}

function triggerStageOptions(e)
{
	
	if(e.type == 'mouseover')
	{
		stageController.hidden = false;
	}	
	else
	{
		stageController.hidden = true;
	}
}

function prevNextClicked()
{
	if(this.label == undefined)
	{
		console.log("none");	
	}
	else
	{
		var imgSrc = $("#"+this.label).children("img").attr('src');
		var id = this.label;
		
		if(nextPrevType == 2)
		{
			vidid = document.getElementById(id).label;
			ytPlayer = '<iframe width="640" height="390" src="http://www.youtube.com/embed/'+vidid+'?rel=0&controls=0&showinfo=0&autoplay=1" frameborder="0"></iframe>';
		}
		openGallery(id, imgSrc, nextPrevType);
	}	
}

function deleteBtnClicked()
{
	var url = 'gallery-functions.php';
	var param = '?purpose=delete&id='+this.label;
	url += param;
	
	$.ajax(
	{
		url: url,
		type: "GET",
		success: function(res)
		{
			closeGallery();
			loadGallery(nextPrevType);
		}
	});	
}
