<?php

include "bootstrap.php";

require_once("vab/userMgr.class.php");

UserMgr::Logout();

header("location: /index");
exit(0);
