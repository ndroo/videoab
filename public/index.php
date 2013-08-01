<?php

include "bootstrap.php";
require_once("vab/userMgr.class.php");

//login?
if(isset($_POST['email']))
{
	$email = $_REQUEST['email'];
	$password = $_REQUEST['password'];

	$user = UserMgr::Login($email,$password);
	if($user != null)
	{
		header("location: /portal");
		exit(0);
	}
	else
	{
		$smarty->assign("error",true);
	}
}
$smarty->display("index.tpl");
