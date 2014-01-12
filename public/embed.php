<?php

include "bootstrap.php";
require_once("vab/embedMgr.class.php");

$embed_id = $_REQUEST['embed_id'];
if(isset($_REQUEST['code']))
{
	//generate embed code
	$embed_code = '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
			<script type="text/javascript">
		    	$.ajax({
			        type:"POST",
			        url:"'.APP_URL.'/embed?embed_id='.$embed_id.'",
			        success: function(html){
				        console.log("Video render success:'.$embed_id.'");
				        document.getElementById("embed").innerHTML = html;
			        }
			    });
			</script>
			<div id="embed"></div>';

	$success_code = '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
			 <script type="text/javascript">
		    	$.ajax({
			        type:"POST",
			        url:"'.APP_URL.'/success?embed_id='.$embed_id.'",
			        success: function(html){
				        console.log("Embed view success: '.$embed_id.'");
			        }
			    });
			</script>';


	$smarty->assign("embed_code",htmlentities($embed_code));
	$smarty->assign("success_code",htmlentities($success_code));
	$smarty->assign("mode","code");
}
else
{
	//logs the video being played (potentially) and stores a session variable so when we hit the success page we can track it worked
	$video = EmbedMgr::GetVideo($embed_id);
	$smarty->assign("embed_code",$video->embed_code);
	$smarty->assign("mode","video");
}

$smarty->display("embed.tpl");
