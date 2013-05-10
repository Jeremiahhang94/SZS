<?php
include_once "admin-includes.php";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>SZSS : Gallery</title>


<script>
$(document).ready(function()
{
	showcase = new Showcase("gallery-showcase");
	
});

</script>
<script src='galleryJS.js'></script>
<script src='showcase.js'></script>

</head>

<body>

<div id = 'main'>
<?php  include_once 'admin-header.php'; ?>
<div id = 'content'>

<div id = 'page-title'> Gallery </div>

<div id = 'gallery-showcase'>
</div>

<div class='gallery-side' id = 'gallery-images' style='border-right: #AAA dotted 1px;'>

<div id='gallery-display-images'>
<div id='gallery-add-images-btn' class='gallery-class shadow'>Add Image</div>

<div id = 'gallery-display-images-generated'>
<div class='gallery-class shadow'></div>
</div>
</div><!-- end display images -->

<div id = 'add-image-form-preview'>

<form id='galleryUploadForm' action='' method='post' onsubmit='return addPhoto()' enctype="multipart/form-data">
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