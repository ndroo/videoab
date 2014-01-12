<?php

class Embed
{
	public $embed_id;
	public $user_id;
	public $date_created;
	public $enabled;

	public function __construct($obj = null)
	{
		if(!empty($obj))
		{
			$this->embed_id = $obj->embed_id;
			$this->user_id = $obj->user_id;
			$this->date_ceated = $obj->date_created;
			$this->enabled = $obj->enabled;
		}
	}

	public function __get($val)
	{
		switch($val)
		{
			case "videos":
				$db = $GLOBALS['db'];
				$db = $db->getConn("write");
				$embed_con = $db->quoteInto("embed_id = ?",$this->embed_id);
				$sql = "select * from videos where $embed_con";
				$res = $db->query($sql);
				$result = array();
				while($obj = $res->fetchObject())
				{
					$result[] = $obj;
				}
				return $result;
				break;
		}
	}
}
