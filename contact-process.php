<?php

//default values
$sendto = "longan94@gmail.com";

//get values
$name = $_GET['name'];
$email = $_GET['email'];
$purpose = $_GET['purpose'];
$message = $_GET['message'];

$subject = $purpose ." - ". $name;
$messageBody = "Name: ".$name."\r\n";
$messageBody .= "Email: ".$email."\r\n";
$messageBody .= "Purpose: ".$purpose."\r\n";
$messageBody .= nl2br($message);

$sent = mail($sendto, $subject, $messageBody);
if($sent)
{
	echo "Sent";	
}
else
{
	echo "fail";	
}

?>