<?php

class User
{
	public $email;
	public $password;
	public $user_id;

	public function __construct($db_o = null)
	{
		if($db_o != null)
		{
			$this->email = $db_o->email;
			$this->password = $db_o->password;
			$this->user_id = $db_o->user_id;
		}
	}
}
