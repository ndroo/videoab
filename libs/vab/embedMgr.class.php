<?php

class EmbedMgr
{
	public static function GetVideo($embed_id)
	{
		$db = $GLOBALS['db'];
		$db = $db->getConn("read");

		//if the user has already been assigned a video_id, lets return the same content
		if(self::GetSessionVideo($embed_id) != null)
		{
			$video = $db->quoteInto("video_id = ?",self::GetSessionVideo($embed_id));
			$sql = "select * from videos where $video limit 1;";
			$res = $db->query($sql);
			$obj = $res->fetchObject();
			return $obj;
		}
		else
		{

			$embed = $db->quoteInto("embed_id = ?",$embed_id);
			$sql = "select * from videos where $embed order by rand() limit 1;";
			//use the sql that is relative to this user
			$res = $db->query($sql);
			$obj = $res->fetchObject();
			if(is_object($obj))
			{
				//store the video ID in the session so we can confirm it
				self::SetSessionVideo($embed_id,$obj->video_id);

				//log the play
				self::LogPlay($obj->video_id);
				return $obj;
			}
		}
	}

	private static function SetSessionVideo($embed_id,$video_id)
	{
		$_SESSION["video_id_for_embed_id_".$embed_id] = $video_id;
	}

	private static function GetSessionVideo($embed_id)
	{
		if(isset($_SESSION["video_id_for_embed_id_".$embed_id]))
			return $_SESSION["video_id_for_embed_id_".$embed_id];
	}

	private static function LogPlay($video_id)
	{
		//nothing we can do
		if($video_id == null)
			return;

		$db = $GLOBALS['db'];
		$db = $db->getConn();

		$r = array();
		$r['video_id'] = $video_id;
		$r['action'] = "PLAY";
		$r['visitor_hash'] = self::GetVisitorHash();
		try
		{
			$db->insert("action_log",$r);
			return true;
		}
		catch(Exception $ex)
		{
			//duplicate
		}
		return false;
	}

	public static function LogSuccess($embed_id)
	{
		$video_id = self::GetSessionVideo($embed_id);

		//nothing we can do
		if($video_id == null)
			return;

		$db = $GLOBALS['db'];
		$db = $db->getConn();

		$r = array();
		$r['video_id'] = $video_id;
		$r['action'] = "SUCCESS";
		$r['visitor_hash'] = self::GetVisitorHash();
		try
		{
			$db->insert("action_log",$r);
			return true;
		}
		catch(Exception $ex)
		{
			//duplicate
		}
		return false;
	}

	public static function GetVisitorHash()
	{
		if(!isset($_SESSION['visitor_hash']))
			$_SESSION['visitor_hash'] = self::GenerateRandomString();

		return $_SESSION['visitor_hash'];
	}

	private static function GenerateRandomString($length = 64) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $randomString;
	}
}
