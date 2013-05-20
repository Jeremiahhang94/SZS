// JavaScript Document

function fadeContent()
{
	/*
		used in all pages
		fades in content
	*/
	$(".main-content").hide();
	$(".main-content").fadeIn(300);	
}

function nextPicture(id)
{
	/**
	*
	* Place of Usage: index.php
	* Description: Slides up the image
	*
	*/
	
	$("#currentImage").animate({'margin-top': '-=280'}, 1000,function()
	{
		$(this).remove();
		
		$("#nextImage").attr("id", "currentImage");
	
		var src = 'images/intro-pictures/intro'+id+'.jpg';
		var toAppend = "<div class='introImage shadow' id ='nextImage'><img src='"+src+"'/></div>";
	
		$("#introImageContainer").append(toAppend);
	
		picNo++;
		if(picNo > noOfPic)
		{
			picNo = 1;	
		}
	});
}


/*

updateCourse() & showCourse()

Place of Usage: courses.php
Description: updateCourse() removes current course on display and calls showCourse() which show the next course

*/

function updateCourse()
{
	
	if(currentCourse != '')
	{
		$("#"+currentCourse).fadeOut(200, showCourse);
	}
	else
	{
		showCourse();	
	}
}

function showCourse()
{
	var selected = nextCourse.toLowerCase();
		
	getCourses(selected);
	$("#"+selected).fadeIn(200);
	
	currentCourse = selected;
}


//step 1
function loadCourses()
{
	var url = "admin/course-get-all.php";
	$.ajax(
	{
		type:"GET",
		url: url,
		success: function(data)
		{
			if(data != "fail")
			printAllCourse(data);
			else
			alert("Unable to add course");
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
	
	$(".one-cert").on("click", loadCert);
}

function printCertTab(data)
{
	var newCert = new OneCert(data);
	$("#certs-tabs").append(newCert.title);
	$(".one-cert").on("click", loadCert);
}

function OneCert(cert)
{
	var id = cert['id'];
	var name = cert['name'];
	var title = printTitle(id, name);
	
	return {id: id, name: name, title: title};
}

function printTitle(id, name)
{
	return "<div class = 'one-cert' id='"+id+"' ><p>"+id+"<span>"+name+"</span></p></div>";
}

//step 2
function loadCert(e)
{
	var course = $(this).attr('id');
	if (course == selectedCourse) return true;
	
	$(".one-cert").removeClass('cert-selected')
	$(this).addClass('cert-selected');
	
	$("#step3").fadeOut(200);
	$("#step2").fadeOut(200, function(){getCourse(course)});
}
function getCourse(course)
{
	selectedCourse = course;
	//$("#step2").load();
	
	getCertDetail(selectedCourse);
	
}

function getCertDetail(certId)
{
	var url = "admin/courses-function.php";
	var param = "?p=get&id="+certId;
	url += param;
	$.ajax(
	{
		url:url,
		type:"GET",
		success:function(data)
		{	
			$("#certs-given-info").empty().append(printCertDetail(data)); 
			$("#step2").fadeIn(200);
		}
		
	});
}

function printCertDetail(data)
{
	data = $.parseJSON(data);
	var toAppend = 	"<div class = 'one-info'><p><span>Pre-Requisites:</span> "+ data['require'] +"</p></div>"
	toAppend += 	"<div class = 'one-info'><p><span>Min. Age:</span> "+ data['age'] +" Years Old</p></div>"
	toAppend += 	"<div class = 'one-info'><p><span>Fee:</span> $"+ data['fee'] +"</p></div>"
	toAppend += 	"<div class = 'one-info'><p><span>Duration:</span> "+ data['session'] +" sessions, "+ data['duration']+" hours each</p></div>"
	toAppend += 	"<div class = 'one-info'><p><span>Lesson:</span> Every "+ data['day'] +" "+ data['time'] +"</p></div>"
	 
	return toAppend;
	
}

$.fn.loadLinks = function(className) 
{
	var links = 
	{
		About: "/SZS/about.php",
		Courses: "/SZS/courses.php",
		Gallery: "/SZS/gallery.php",
		Contact: "/SZS/contact.php"
	}
	
	return this.each(function()
	{
		var $this = $(this).empty();
		
		for(var i in links)
		{
			/*
			<div class ='navItem'>
			<a href="about.php">About</a>
			</div>
			*/
			var linkClass = $("<div>", {
				class: className
				});
			
			var linkHref = $("<a>", {
				href: links[i],
				text: i
				})
				
			linkClass.append(linkHref).appendTo($this);
				
		}
			
	});
}