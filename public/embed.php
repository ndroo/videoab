<?php

include "bootstrap.php";

require_once("vab/embedMgr.class.php");

if(isset($_REQUEST['embed_id']))
{
	$embed_id = $_REQUEST['embed_id'];

	//logs the video being played (potentially) and stores a session variable so when we hit the success page we can track it worked
	$smarty->assign("embed_code",EmbedMgr::GetVideo($embed_id)->embed_code);
}

$smarty->display("embed.tpl");
