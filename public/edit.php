<?php

include "bootstrap.php";

require_once("vab/embedMgr.class.php");
require_once("vab/userMgr.class.php");

//load the emebed and make it available to the UI
$embed_id = $_REQUEST['embed_id'];
$embed = EmbedMgr::GetEmbed($embed_id);
$smarty->assign("embed",$embed);

//in the case we're making a change
if(isset($_REQUEST['action']))
{
	//various actions
	switch($_REQUEST['action'])
	{
		case "addvideo":
			EmbedMgr::AddVideo($embed_id,$_REQUEST['embed_code']);
			break;
		case "removevideo":
			EmbedMgr::RemoveVideo($_REQUEST['video_id']);
			break;
		case "update":
			//@todo implement
			break;
	}

	//rediret to ensure the UI gets an updated embed object
	header("location: edit?embed_id=$embed_id");
	exit(0);
}

$smarty->display("edit.tpl");
