<?php
include_once 'admin-includes.php';
ob_end_clean();

$id = $_GET['id'];
$p = $_GET['p'];

if($p == "load")
{
	$profile = ProfileFactory::getProfileById($id);	
	$profile = json_encode($profile);
	print_r($profile);
}

if($p == "delete")
{
	$delete = ProfileFactory::deleteProfileById($id);	
}

if($p == "getAll")
{
	
	$oneProfile = "<div class = 'one-profile' id='addNewProfile'>
<div class = 'one-profile-add'>Add <br /> Profile</div>
</div>";
	echo $oneProfile;
	
	$allProfile = ProfileFactory::getAllProfile();
	foreach($allProfile as $curProfile)
	{
		$oneProfile = "<div class = 'one-profile' id='$curProfile->id'>";
		$oneProfile .= "<div class = 'one-profile-img'><img src='$curProfile->img' style='max-width: 204px; min-height: 204px;'/></div>";
		$oneProfile .= "<div class = 'one-profile-name'> $curProfile->name </div>";
		$oneProfile .= "</div>";
		echo $oneProfile;
	}
	
	
}

?>