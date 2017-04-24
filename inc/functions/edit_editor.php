<?php 

    function find_mobile_browser($style_pres=false) {
	$mov_preg_metch = preg_match('/(iphone|ipad|ipod|android|mobile|smartphone|blackberry|iemobile|kindle|opera mobi|opera mini)/i', $_SERVER['HTTP_USER_AGENT']);
	if($style_pres==false){
		if($mov_preg_metch) {
			return true;
		}
		elseif($_COOKIE["style_set"]=="style_mobile.css")
		{
			return true;
		}
		else {
			return false;
		}
		}
	elseif($style_pres=true){
		if(@$_COOKIE["style_set"]=="style_mobile.css") {
			return true;
		}
		elseif($mov_preg_metch and $_COOKIE["style_set"]!="inc/style_mobile.css" and $_COOKIE["style_set"] != "")
		{
			return false;
		}
		else {
			return false;
		}	
	}
}

?>