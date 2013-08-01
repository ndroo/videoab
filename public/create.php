<?php

include "bootstrap.php";
require_once("vab/userMgr.class.php");

//create?
if(isset($_POST['email']))
{
	$email = $_REQUEST['email'];
	$password = $_REQUEST['password'];

	$user_id = UserMgr::Create($email,$password);
	if($user_id != null)
	{
		UserMgr::Login($email,$password);
		header("location: /portal");
		exit(0);
	}
	else
	{
		$smarty->assign("error",true);
	}
}
$smarty->display("create.tpl");
