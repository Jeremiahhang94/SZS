<?php
include_once 'admin-includes.php';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>SZS : Add Profile</title>
</head>

<body>

<div id = 'main'>
<?php include_once 'admin-header.php' ?>
<div id = 'content'>

<div id = 'page-title'>Add A New Mentor</div>
<div id = 'profile-add'>
<form onsubmit = 'return validate();' name='profileAddForm' action = 'profiles-add-process.php' method='post' enctype="multipart/form-data">

<div id = 'profile-add-image'>

<div id = 'profile-add-text-name'>
<input type = 'text'  name='profileName' placeholder='Name' required="required"/>
</div>

<div id = 'add-image-preview'>
<img src='#' id = 'image-preview' width='180'/>
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

<input type='submit' value='Add Profile' style='float: right;' />
</div>

</form>
</div><!-- end profile add -->

<a href='#' onclick = 'return validate()'>validate</a>

<div id = 'profile-add-confirm'>

</div>

</div>
</div>

</body>
</html>