<?php

require_once("vab/user.class.php");

class UserMgr
{
	public static function Create($email,$password)
	{
		$db = $GLOBALS['db'];
		$db = $db->getConn();

		try
		{
			$r = array();
			$r['email'] = $email;
			$r['password'] = md5($password);
			$db->insert("users",$r);
		}
		catch(Exception $ex)
		{
			return null;
		}
		return $db->lastInsertId();
	}

	public static function Load($user_id)
	{
		$db = $GLOBALS['db'];
		$db = $db->getConn();

		$con = $db->quoteInto("user_id = ?",$user_id);
		$sql = "select * from users where $con limit 1;";
		$res = $db->query($sql);
		$obj = $res->fetchObject();
		if(is_object($obj))
		{
			return new User($obj);
		}
	}

	public static function LoadByEmail($email)
	{
		$db = $GLOBALS['db'];
		$db = $db->getConn();

		$con = $db->quoteInto("email = ?",$email);
		$sql = "select user_id from users where $con limit 1;";
		$res = $db->query($sql);
		$obj = $res->fetchObject();
		if(is_object($obj))
		{
			return self::Load($obj->user_id);
		}
	}

	public static function Login($email,$password)
	{
		$db = $GLOBALS['db'];
		$db = $db->getConn();

		$e = $db->quoteInto("email = ?",$email);
		$p = $db->quoteInto("password = ?",md5($password));
		$sql = "select user_id from users where $e and $p limit 1;";
		$res = $db->query($sql);
		$obj = $res->fetchObject();
		if(is_object($obj))
		{
			$_SESSION['user_id'] = $obj->user_id;
			return self::Load($obj->user_id);
		}
	}

	public static function Logout()
	{
		$_SESSION['user_id'] = null;
		session_destroy();
	}

	public static function GetEmbeds($user_id)
	{
		$db = $GLOBALS['db'];
		$db = $db->getConn();

		$user = $db->quoteInto("user_id = ?",$user_id);
		$sql = "select * from embeds where $user;";
		$res = $db->query($sql);
		$embeds = array();
		while($obj = $res->fetchObject())
		{
			$embeds[] = $obj;
		}
		return $embeds;
	}
}
