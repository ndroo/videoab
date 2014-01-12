<?php

include "bootstrap.php";

require_once("vab/embedMgr.class.php");
require_once("vab/userMgr.class.php");

//create a new Embed
$embed_id = EmbedMgr::Add();
header("location: edit?embed_id=$embed_id");




