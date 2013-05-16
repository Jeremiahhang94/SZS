<?php
include_once 'admin-includes.php';
ob_end_clean();

$id = $_GET['id'];
$p = $_GET['p'];

if($p == "get")
{
	$allAnno = AnnouncementFactory::getAllAnnouncement();
	if(!$allAnno) echo 0;
	else print_r(json_encode($allAnno));	
}

if($p == "update")
{
	$annoUpdated = AnnouncementFactory::toggleAnnouncementShow($id);
	echo $annoUpdated;
}

if($p == "add")
{
	$anno = new Announcement();
	$anno->text = $_GET['text'];
	$anno->show = 0;
	
	$annoAdded = AnnouncementFactory::addAnnouncement($anno);
	if(!$annoAdded) echo 0;
	
	else echo true;	
}

if($p == "delete")
{
	$annoDeleted = AnnouncementFactory::deleteAnnouncement($id);
	if(!$annoDeleted) echo 0;
	
	else echo true;	
}

if($p == "up")
{
	$anno = AnnouncementFactory::getAnnouncementById($id);
	$anno->text = $_GET['text'];
	$anno->show = 0;
	
	$annoUpdated = AnnouncementFactory::updateAnnouncement($anno);
	echo $annoUpdated;
}
?>