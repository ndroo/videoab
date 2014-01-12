<?php

require_once("vab/embed.class.php");

class EmbedMgr
{
	public static function RemoveVideo($video_id)
	{
		$db = $GLOBALS['db'];
		$db = $db->getConn("write");

		$video_con = $db->quoteInto("video_id = ?",$video_id);
		$sql = "delete from videos where $video_con limit 1;";
		$db->query($sql);
	}

	public static function AddVideo($embed_id,$embed_code)
	{
		$db = $GLOBALS['db'];
		$db = $db->getConn("write");

		$v = array();
		$v['embed_code'] = $embed_code;
		$v['embed_id'] = $embed_id;
		$db->insert("videos",$v);
		return $db->lastInsertId();
	}

	//returns an embed object
	public static function GetEmbed($embed_id)
	{
		$db = $GLOBALS['db'];
		$db = $db->getConn("write");

		$embed_con = $db->quoteInto("embed_id = ?",$embed_id);
		$sql = "select * from embeds where $embed_con limit 1;";
		$res = $db->query($sql);
		$obj = $res->fetchObject();
		if(is_object($obj))
		{
			return new Embed($obj);
		}
	}

	//creats a new embed
	public static function Add($user_id = null)
	{
		//either use the passed in user or the user from the session (if available)
		if(empty($user_id) && !empty($_SESSION['user_id']))
			$user_id = $_SESSION['user_id'];

		if(!empty($user_id))
		{
			$db = $GLOBALS['db'];
			$db = $db->getConn("read");

			$r = array();
			$r['user_id'] = $user_id;
			$r['enabled'] = 1; //on by default?
			$db->insert("embeds",$r);
			return $db->lastInsertId();
		}

		return null; //@tdoo id prefer to throw an exception here
	}

	public static function GetStats($embed_id)
	{
		$db = $GLOBALS['db'];
		$db = $db->getConn("read");

		$embedCon = $db->quoteInto("embed_id = ?",$embed_id);
		$sql = "select video_id,action,count(*) as num_actions from action_log join videos using (video_id) where $embedCon group by action,video_id;";
		$res = $db->query($sql);
		$result = array();
		while($obj = $res->fetchObject())
		{
			$results[] = $obj;
		}
		return $results;
	}

	public static function GetVideo($embed_id)
	{
		$db = $GLOBALS['db'];
		$db = $db->getConn("read");
		$obj = null;

		//if the user has already been assigned a video_id, lets return the same content
		if(self::GetSessionVideo($embed_id) != null)
		{
			$video = $db->quoteInto("video_id = ?",self::GetSessionVideo($embed_id));
			$sql = "select * from videos where $video limit 1;";
			$res = $db->query($sql);
			$obj = $res->fetchObject();
		}

		//get a random video and set the video_id (this also deals with the case where the video no longer exists)
		if(empty($obj))
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
			}
		}

		self::LogPlay($obj->video_id);
		return $obj;
	}

	private static function SetSessionVideo($embed_id,$video_id)
	{
		$_SESSION["video_id_for_embed_id_".$embed_id] = $video_id;
	}

	private static function GetSessionVideo($embed_id)
	{
		if(isset($_SESSION["video_id_for_embed_id_".$embed_id]))
			return $_SESSION["video_id_for_embed_id_".$embed_id];
		else
			return null;
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
		//since the user has played the video, the video_id should be in the session
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
