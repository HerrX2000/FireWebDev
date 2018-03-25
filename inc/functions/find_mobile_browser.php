<?php 
function find_mobile_browser($style_pres=false) {
	//list of keywords identifying a mobile device
	$mov_preg_metch = preg_match('/(iphone|ipad|ipod|android|mobile|smartphone|blackberry|iemobile|kindle|opera mobi|opera mini)/i', $_SERVER['HTTP_USER_AGENT']);
	if($style_pres==false){
		if($mov_preg_metch) {
			//if key match
			return true;
		}
		/*
		outdate style_mobile.css not allways valide
		*/
		/*
		disabled since 0.7 b/c style is global not cookie
		elseif(@$_COOKIE["style_set"]=="style_mobile.css") {
			//if cookie = mobile 
			return true;
		}
		*/
		else {
			return false;
		}
		}
	elseif($style_pres=true){
		if($mov_preg_metch) {
			return true;
		}
		else {
			return false;
		}
		/*
		outdate style_mobile.css not allways valide
		if(@$_COOKIE["style_set"]=="style_mobile.css") {
			//if cookie = mobile 
			return true;
		}
		else*/
		/*
		disabled since 0.7 b/c style is global not cookie
		
		if($mov_preg_metch and $_COOKIE["style_set"]!="inc/style_mobile.css" and $_COOKIE["style_set"] != "")
		{
			//if key match and cookie!=mobile
			return false;
		}
		else {
			return false;
		}	
		*/
	}
}

?>