<?php 
class fw_var
{
    function find_mobile_browser() {
	if(preg_match('/(iphone|ipad|ipod|android|mobile|smartphone|blackberry|iemobile|kindle|opera mobi|opera mini)/i', $_SERVER['HTTP_USER_AGENT']) and $_COOKIE["style_set"]=="inc/style_mobile.css") {
        return true;
    }
	elseif($_COOKIE["style_set"]=="inc/style_mobile.css")
	{
        return true;
    }
	else {
        return false;
    }
	
}
}
?>