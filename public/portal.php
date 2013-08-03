<?php

include "bootstrap.php";

require_once("vab/embedMgr.class.php");
require_once("vab/userMgr.class.php");

//get the embeds for this user
$smarty->assign("embeds",UserMgr::GetEmbeds($_SESSION['user_id']));

$smarty->display("portal.tpl");
