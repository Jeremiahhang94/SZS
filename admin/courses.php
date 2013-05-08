<?php
include_once "admin-includes.php";
isLoggedIn();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>SZSS : Courses</title>
<script>
var displayMode = 1;
var selectedCourse = '';
$(document).ready(init);

function init()
{
	$("#content").hide().fadeIn(300);
	$("#add-course").hide();
	loadCourses();
	$("#addCourseForm").submit(validate);
}
function selectCourse()
{
	var id = $(this).attr("id");
	if(id == 'addCourse')
	{
		$("#certs-info").fadeOut(200);
		$("#certs-tabs-container").fadeOut(200, function(){showAddCourse()});	
	}
	else
	{
		$(".one-cert").removeClass('cert-selected')
		$(this).addClass('cert-selected');
		selectedCourse = id;
		getCertDetail(id);
	}
}
function showAddCourse()
{
	$("#add-course").fadeIn(200);
}
function showCourses()
{
	$("#add-course").fadeOut(200, function()
	{  
		displayMode = 1;
		$("#certs-tabs-container").css("width", "100%").fadeIn(200);
	});
}
function validate(e)
{
	e.preventDefault();
	var form = document.forms['addCourseForm'];
	
	var id = form.id.value;	
	var name = form.name.value;	
	
	var require = form.require.value;
		
	var age = form.age.value;	
	var fee = form.fee.value;
		
	var session = form.session.value;
	var duration = form.duration.value;
	
	var daySelect = form.day;	
	var day = daySelect.options[daySelect.selectedIndex].text;
	var time = form.time.value;	
	
	var param = "?id="+id+"&name="+name+"&require="+require+"&age="+age+"&fee="+fee+"&session="+session+"&duration="+duration+"&day="+day+"&time="+time;
	var url = "courses-add.php" + param;
	
	$.ajax(
	{
		type:"GET",
		url: url,
		success: function(data)
		{
			form.reset();
			showCourses();
			printCertTab($.parseJSON(data));
		}
	}
	);
	
	return false;
}

function loadCourses()
{
	var url = "course-get-all.php";
	$.ajax(
	{
		type:"GET",
		url: url,
		success: function(data)
		{
			if(data != "fail")
			printAllCourse(data);
		}
	}
	);
	
}

function printAllCourse(data)
{
	var jsonData = $.parseJSON(data);
	for(var i = 0; i<jsonData.length; i++)
	{
		printCertTab(jsonData[i])
	}
	
	$(".one-cert").on("click", selectCourse);
}

function OneCert(cert)
{
	var id = cert['id'];
	var name = cert['name'];
	var title = printTitle(id, name);
	
	return {id: id, name: name, title: title};
}

function printCertTab(data)
{
	var newCert = new OneCert(data);
	$("#certs-tabs").append(newCert.title);
	$(".one-cert").on("click", selectCourse);
}

function printTitle(id, name)
{
	return "<div class = 'one-cert' id='"+id+"' ><p>"+id+"<span>"+name+"</span></p></div>";
}

function getCertDetail(certId)
{
	var url = "courses-function.php";
	var param = "?p=get&id="+certId;
	url += param;
	$.ajax(
	{
		url:url,
		type:"GET",
		success:function(data)
		{
			if(displayMode == 1)
			{
				$("#certs-tabs-container").fadeOut(200, function()
				{  
					$(this).css("width", "480px").fadeIn(200); 
				});
				displayMode = 2;
			}
			
			printCertDetail(data); 
		}
		
	});
}

function printCertDetail(data)
{
	data = $.parseJSON(data);
	var toAppend = 	"<div class = 'one-info'><p><span>Pre-Requisites:</span> "+ data['require'] +"</p></div>"
	toAppend += 	"<div class = 'one-info'><p><span>Min. Age:</span> "+ data['age'] +"</p></div>"
	toAppend += 	"<div class = 'one-info'><p><span>Fee:</span> "+ data['fee'] +"</p></div>"
	toAppend += 	"<div class = 'one-info'><p><span>Duration:</span> "+ data['session'] +" sessions, "+ data['duration']+" hours each</p></div>"
	toAppend += 	"<div class = 'one-info'><p><span>Lesson:</span> Every "+ data['day'] +" "+ data['time'] +"</p></div>"
	toAppend += 	"<div class = 'one-info'><p> <button onclick='deleteCourse()'> Delete </button> </p></div>"
	 
	$("#certs-info").fadeOut(200, function()
	{
		$(this).empty().append(toAppend).fadeIn(200);
	});
	
}

function deleteCourse()
{
	var url = "courses-function.php";
	var param = "?p=delete&id="+selectedCourse;
	url += param;
	$.ajax(
	{
		url:url,
		type:"GET",
		success:function(data)
		{	
			var toClick = '';
			var lastDiv = $(".one-cert").last().attr('id');
			if(selectedCourse == lastDiv)
			toClick = $("#"+selectedCourse).prev();
			else
			toClick = $("#"+selectedCourse).next();
			
			$("#"+selectedCourse).remove();
			toClick.click();
		}
		
	});
	
	
	
}
</script>
</head>

<body>

<div id ='main'>
<?php include_once 'admin-header.php'; ?>

<div id = 'content'>
<div id = 'page-title'> Courses </div>

<div id = 'certs-tabs-container'>
<div id = 'certs-tabs'>
<div class = 'one-cert' id='addCourse'><p>Add<span>Add Course</span></p></div>
</div>
</div>

<div id = 'add-course'>

<form id='addCourseForm' name='addCourseForm' method='post' action='#' >
<p>
<input type = 'text'  name='id' placeholder='id' style='width: 70px' required/>
<input type = 'text' name='name' placeholder='name' style='width: 200px' required/>
</p>
<p><textarea name='require' placeholder='requirements' style='width: 275; height: 80px;' required></textarea></p>

<p>
<input type = 'number' name='age' placeholder='age' required/>
<input type = 'number' name='fee' placeholder='fee' required/>
</p>
<p>
<input type = 'number' name='session' placeholder='No. Of Sessions'  required/>
<input type = 'text' name='duration' placeholder='Hours - eg 2-3(hours)'  required/>
</p>

<p>
<select name='day' id ='selectDay' style=' width: 128px; margin-right: 5px; ' >
<?php
for($i = 1; $i <= 7; $i++)
{
	$monthName = date("l", mktime(0, 0, 0, 0, $i));
	
	echo "<option value=$i> $monthName </option>";	
}

?>
</select>
<input type = 'text' name='time' placeholder='time - eg 6.30pm'/>
</p>

<p> <input type='submit' /></p>

</form>

</div>

<div id = 'course-information'>

<div id = 'certs-info'>

</div>

</div>


</div>

</div>

</body>
</html>