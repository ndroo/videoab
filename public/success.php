<?php

include "bootstrap.php";

require_once("vab/embedMgr.class.php");

if(isset($_REQUEST['embed_id']))
{
	$embed_id = $_REQUEST['embed_id'];

	//log the success
	$smarty->assign("success",EmbedMgr::LogSuccess($embed_id));
}

$smarty->display("success.tpl");
