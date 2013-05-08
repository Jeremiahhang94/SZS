<?php
/*
created: 20/4 1313 Jeremiah 
last edited 20/4 1313 Jeremiah

purpose: course model

*/
class Course
{
	public $id;
	public $name;
	public $days;
	public $time;
	public $venue;
	public $certId;
	
	function getVenueName()
	{
		$query = "SELECT * FROM venue WHERE id = " . $this->venue;
		$answer = mysqli_query(connect::getConnection(), $query);
		if(!$answer)
		{
			return false;	
		}
		
		$curVenue = mysqli_fetch_assoc($answer);
		$venue = $curVenue['venue_name'];
		
		return $venue;
		
	}
	
	function getCertName()
	{
		$query = "SELECT * FROM certs WHERE id = " . $this->certId;
		$answer = mysqli_query(Connect::getConnection(), $query);
		if(!$answer)
		{
			return false;	
		}
		
		$curCert = mysqli_fetch_assoc($answer);
		$cert = $curCert['cert_name'];
		
		return $cert;
	}
	
	function getDaysName()
	{
		switch ($this->days)
		{
			case 0: return "Monday"; break;
			case 1: return "Tuesday"; break;
			case 2: return "Wednesday"; break;
			case 3: return "Thursday"; break;
			case 4: return "Friday"; break;
			case 5: return "Saturday"; break;	
			case 6: return "Sunday"; break;
		}
	}
		
}

?>