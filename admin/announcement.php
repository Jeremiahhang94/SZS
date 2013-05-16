<?php
include_once "admin-includes.php";
isLoggedIn();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>SZSS : Announcement</title>
<script>
$(document).ready(init);

function init()
{
	$("#content").hide().fadeIn(300);
	
	getAllAnno();
	$("#anno-add").click(showAddAnno);
	$("#add-anno-container").hide();
}

function showAddAnno()
{
	$("#anno-add").fadeOut(200, function(){$("#add-anno-container").fadeIn(200)});
}

function getAllAnno()
{
	var url = "announcement-functions.php";
	var param = "?p=get&id=";
	url+=param;
	
	$.ajax({
		url:url,
		type:"GET",
		success: function(res)
		{
			res = $.parseJSON(res);
			showAllAnno(res);	
		}
		});
}

function showAllAnno(data)
{
	for(var i = 0; i<data.length; i++)
	{
		var curAnno = data[i];
		
		var anno = $("<div>", {
				class: 'anno-class',
				id: 'anno'+curAnno.id,
				text: curAnno.text,	
				label: curAnno.show
			}).appendTo("#annoContainer-generate");	
	}
	
	
	$(".anno-class").setupAnno();
}

function addAnnoSubmit()
{
	var input = document.forms['addAnnoForm'].anno.value;
	var url = "announcement-functions.php";
	var param = "?p=add&id=&text="+input;
	url+=param;
	
	$.ajax({
		url:url,
		type:"GET",
		success:function(res)
		{
			if(res) reloadAnno();
		}
		}).done(
		function()
		{
			$("#add-anno-container").fadeOut(200, function(){$("#anno-add").fadeIn(200)});	
		});
	
	return false;	
}

function reloadAnno()
{
	$("#annoContainer-generate").fadeOut(200, function()
		{
			var add = "<div id='anno-add'><p>Add Announcement</p></div>";
			$(this).empty().append(add);
			getAllAnno();
			$(this).fadeIn(200);
		});
}

$.fn.setupAnno = function()
{
	
	var option = ['delete', 'edit'];
	var optionsContainer;
	return this.each(function()
	{
		
		//set up options
		var $this = $(this);
		var text = $this.text();
		$this.empty();
		
		if($this.attr("label") == 1)
		{
			$this.addClass("selected");	
		}
		
		$this.click(toggleSelected);
		
		function toggleSelected()
		{
			if($(this).hasClass("selected"))
			{
				$(this).removeClass("selected");	
			}
			else
			{
				$(this).addClass("selected");	
			}
			
			updateSelectedAnno($(this).attr("id"));
		}
		
		function updateSelectedAnno(id)
		{
			id = id.substr(4,1);
			var url = "announcement-functions.php";
			var param = "?p=update&id="+id;
			url+=param;
			
			$.ajax({
				url: url,
				type: "GET",
				success: function(res)
				{
					console.log(res);
				}	
				});
		}
		
		var textArea = $("<div>", {
			class: "anno-text",
			text: text
			}).appendTo($this);
		
		optionsContainer = $("<div>", {
			class: "anno-options-container",
			}).appendTo($this);
			
		for(var i = 0; i<option.length; i++)
		{
			addOption(option[i]);	
		}
		
		function addOption(val)
		{
			var option = $("<div>", {
			class: "anno-options-class",
			text: val,
			click: execOption,
			}).appendTo(optionsContainer);	
			
		}
		
		function execOption(e)
		{
			e.stopPropagation();
			var id = $this.attr("id").substr(4,1);	
			var todo = $(this).text();
			
			if(todo == 'delete')
			{
				var url = "announcement-functions.php";
				var param = "?p="+todo+"&id="+id;
				url+=param;
			
				$.ajax({
					url:url,
					type: "GET",
					success: function(res)
					{
						if(res)
						{
							$this.fadeOut(200, function(){ $(this).remove(); });
						}
					}
					});
			}
			else if(todo == 'edit')
			{
				var inputContainer = $("<div>", {
					css: {
						width: "100%",
						height: "40px",
						marginBottom: "30px"	
					},
					hidden: true
					});
				var input = $("<input>", {
					type: "text",
					class: "addAnnoInput",
					value: text
					}).appendTo(inputContainer);
					
				var done = $("<input>", {
					type: "submit",
					css:{
						marginLeft: "20px"	
					},
					click: function()
					{
						updateAnno(id, input.val());
					}	
					}).appendTo(inputContainer);
				
				$this.fadeOut(200, function(){$(this).after(inputContainer); inputContainer.fadeIn(200)});
				
			}
			
			function updateAnno(id, text)
			{
				var url = "announcement-functions.php";
				var param = "?p=up&id="+id+"&text="+text;
				url+=param;
				$.ajax({
					url: url,
					type: "GET",
					success: function(res)
					{
						reloadAnno();
					}
					});
			}
		}
			
	});	
}
</script>
</head>

<body>

<div id ='main'>
<?php include_once 'admin-header.php'; ?>

<div id = 'content'>
<div id = 'page-title'> Announcement </div>

<div id = 'annoContainer'>

<div id = 'add-anno-container'>
<form id='add-anno-form' name='addAnnoForm' action='#' method='post' onsubmit='return addAnnoSubmit()'>
<input type = 'text' class="addAnnoInput" name='anno' />
<input type='submit' value='Done' />
</form>
</div>

<div id = 'annoContainer-generate'>
<div id='anno-add'>
<p>Add Announcement</p>
</div>

</div><!-- end generated -->

</div><!-- end annoContainer -->

</div><!-- end content -->
</div><!-- end main --> 

</body>
</html>