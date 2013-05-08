<?php
include_once 'admin-includes.php';
$allProfile = ProfileFactory::getAllProfile();
isLoggedIn();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>SZSS : Profiles</title>

<script>
var selectedProfile = '';
var displayMode = 1;
var formdata, input;
var url = "profile_functions.php";
var selectedProfileDetail;

$(document).ready(function()
{
	init();
	
});

function init()
{
	if(window.FormData)
	{
		formdata = new FormData();
		//document.getElementById("submitBnt").style.display = "none";
	}	
	
	loadProfile();

	$("#add-profile-status ").hide();
	$("#content").hide().fadeIn(300);
	$("#profile-add").hide();
	$("#edit-profile").hide();
}

function loadProfile()
{
	var param = "?p=getAll&id=0";
	
	$.ajax({
		type:"GET",
		url: url+param,
		success: function(data)
		{
			$("#profile-tabs").empty().append(data);
			$(".one-profile").on('click', profileClicked);
		}
		});	
}

function profileClicked(e)
{
	var id = $(this).attr('id');
	if(id == "addNewProfile")
	showAddProfile();
	else
	{
		if(selectedProfile != '')
		$("#"+selectedProfile).removeClass('selectedProfile');
		$(this).addClass("selectedProfile");
		
		selectedProfile = id;
		showSelectedProfile(id);
	}
}

function showSelectedProfile(id)
{
	var param = "?p=load&id="+id;
	
	$.ajax({
		type:"GET",
		url: url+param,
		success: function(data)
		{	
			data = $.parseJSON(data);
			selectedProfileDetail = data;
			showProfileDetail(data);	
		}
		});	
}

function showProfileDetail(data)
{
	$("#edit-profile").fadeOut(200);
	
	if(displayMode == 1)
	{
		$("#profileContainer").fadeOut(200, function(){ $(this).css("width", "480px").fadeIn(200); });	
		displayMode = 2;
	}
	
	var toAppend = "<div class = 'one-info'><p> <span> Name: </span> "+ data['name'] +" </p></div>"
	toAppend += "<div class = 'one-info'><p> <span> Description: </span> "+ data['desc'] +" </p></div>"
	toAppend += "<div class = 'one-info'><p> <span> Achievement: </span> "+ data['achi'] +" </p></div>"
	toAppend += "<button onclick='deleteProfile()'> Delete </button>"
	toAppend += "<button onclick='showEditProfile()'> Edit </button>"
	
	$("#profile-information").fadeOut(200, function(){ $(this).empty().append(toAppend).fadeIn(200); });

}

function showAddProfile()
{
	if(displayMode == 2)
	{
		$("#profileContainer").fadeOut(200, function(){ $(this).css("width", "100%").fadeIn(200); });	
		$("#profile-information, #edit-profile").fadeOut(200);
		
		displayMode = 1;
	}
	$("#profile-tabs").fadeOut(200, function(){$("#profile-add").fadeIn(200)});	
}

function deleteProfile()
{
	var param = "?p=delete&id="+selectedProfile;
	
	var deleteConfirm = confirm("Do you really want to delete this profile?");
	if(!deleteConfirm)
	{
		return false;	
	}
	$.ajax({
		type:"GET",
		url: url+param,
		success: function(data)
		{
			var toClick = '';
			var lastDiv = $(".one-profile").last().attr('id');
			if(selectedProfile == lastDiv)
			toClick = $("#"+selectedProfile).prev();
			else
			toClick = $("#"+selectedProfile).next();
			
			$("#"+selectedProfile).remove();
			toClick.click();	
		}
		});	
}

function showEditProfile()
{
	var form = document.forms['profileEditForm'];
	form.name.value = selectedProfileDetail['name'];
	form.desc.value = selectedProfileDetail['desc'];
	form.achi.value = selectedProfileDetail['achi'];
	form.curImg.value = selectedProfileDetail['img'];
	
	$("#profile-information").fadeOut(200, function(){$("#edit-profile").fadeIn(200);});
	
	
}

function updatePreview(input)
{
	this.input = input;
	if(checkFile(input) && input.files && input.files[0])
	{
		var reader = new FileReader();
		
		reader.onload = function(e)
		{	
			$("#image-preview").fadeOut(200, function(){$(this).attr('src', e.target.result).fadeIn(1000)});
		}
		
		reader.readAsDataURL(input.files[0]);
	}
}
function clearPreview()
{
	$("#image-preview").fadeOut(200, function(){$(this).attr('src', '')});
}

function checkFile(input)
{
	/*
	given to gallery.php
	*/
	var typeValid = false;
	var sizeValid = false;
	
	var type = input.files[0].type;
	var size = input.files[0].size;
	
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

function validate()
{
	var form = document.forms['profileAddForm'];
	
	var img = form.profileImage;
	if(!checkFile(img))
	{
		return false;	
	}
	
	addProfile(form, img);
	
	
	return false;
}

function addProfile(form, img)
{
	if(this.formdata)
	{
		
		formdata.append("profileName", form.profileName.value);
		formdata.append("profileDesc", form.profileDesc.value);
		formdata.append("profileAchi", form.profileAchi.value);
		formdata.append("purpose", "add");
		formdata.append("profileImage", img.files[0]);
		
		$.ajax({  
        url: "profiles-add-process.php",  
        type: "POST",  
        data: formdata,  
        processData: false,  
        contentType: false,  
        success: function (res) {  
			form.reset();
			clearPreview();
            $("#add-profile-status ").hide().empty().html(res).show();
			$("#profile-add").fadeOut(200, function(){ loadProfile(); $("#profile-tabs").fadeIn(200); });
        	}  
    	});  
	}	
}
function editProfile()
{
	
	var form = document.forms['profileEditForm'];
	
	var img = form.img;
	if(img.value != '')
	{
		if(!checkFile(img))
		{
			return false;	
		}
		
		formdata.append("profileImage", img.files[0]);
	}
	else
	{
		img = form.curImg;
		formdata.append("profileImage", img.value);
	}
	
	if(this.formdata)
	{
		formdata.append("profileId", selectedProfile);
		formdata.append("profileName", form.name.value);
		formdata.append("profileDesc", form.desc.value);
		formdata.append("profileAchi", form.achi.value);
		formdata.append("purpose", "edit");
		
		$.ajax({  
        url: "profiles-add-process.php",  
        type: "POST",  
        data: formdata,  
        processData: false,  
        contentType: false,  
        success: function (res) {  
			res = $.parseJSON(res);
			form.reset();
			$("#"+selectedProfile+" .one-profile-img img").fadeOut(200, function(){$(this).attr('src', res['img']).fadeIn(200); });
			showProfileDetail(res)
        	}  
    	});  
	}	
	
	return false;
}
</script>

</head>

<body>

<div id='main'>
<?php include_once 'admin-header.php'; ?>


<div id = 'content'>
<div id = 'page-title'>Mentors</div>

<div id = 'profileContainer'>
<div id = 'profile-tabs'>
<div id = 'add-profile-status'> Profile Added Successfully! </div>

</div><!-- end profile tabs -->

<div id = 'profile-add'>
<form onsubmit = 'return validate();' name='profileAddForm' action = 'profiles-add-process.php' method='post' enctype="multipart/form-data">

<div id = 'profile-add-image'>

<div id = 'profile-add-text-name'>
<input type = 'text'  name='profileName' placeholder='Name' required="required"/>
</div>

<div id = 'add-image-preview'>
<img src='../images/profile-preview.png' id = 'image-preview' width='180'/>
</div>
<input type = 'file' name='profileImage' onchange='updatePreview(this)' style='margin-top: 10px;' required="required"/>

</div>

<div id = 'profile-add-text'>

<div id = 'profile-add-text-desc'>
<textarea name = 'profileDesc' placeholder="Tell me more something fun about this mentor" required="required"></textarea>
</div>

<div id = 'profile-add-text-achi' >
<textarea name = 'profileAchi' placeholder="What are some achievement this mentor have? " required="required"></textarea>
</div>

<input id='submitBnt' type='submit' value='Add Profile' style='float: right;' />
</div>

</form>
</div><!-- add Profile -->



</div>

<div id = 'edit-profile'>
<form name='profileEditForm' onsubmit='return editProfile()' action='#' method = 'post' enctype='multipart/form-data'>
<input type='hidden' name='curImg' value='' />
<p><input type='text' name='name' value='' /></p>
<p>
<textarea name='desc'>
</textarea>
</p>
<p>
<textarea name='achi'>
</textarea>
</p>
<input type='file' name='img' />
</p>
<p>
<input type='submit' value='Update!'/>
</p>
</form>
</div>
<div id = 'profile-information'>

</div>

</div>

</body>
</html>