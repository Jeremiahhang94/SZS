<?php
$noNeedCheck = true;
include_once "admin-includes.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Login</title>
</head>

<body>
<div id = 'main'>

<p class='title'> SZSS Login </p>
<div id = 'login-container'>
<form action='login-process.php' method='post'>
<table>
<tr><td>
<input type='text' name='username' placeholder='username'/>
</td></tr>
<tr><td>
<input type='text' name='password' placeholder='password'/>
</td></tr>

<tr><td>
<input type='submit' value='login' style='margin-top: 20px; width: 80px;'/>
</td></tr>
</table>
</form>
</div>

</div><!-- end main -->
</body>
</html>