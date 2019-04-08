<?php

function cookie_active(){
	if(isset($_COOKIE['cookie_active']) and $_COOKIE['cookie_active'] == 1){
		return true;
	}
	else{
		return false;	
	}
}

class cookie
	{
	//cookie style
	function run(){
		setcookie("cookie_active","1",null, FW_COOKIE_PATH, FW_COOKIE_DOMAIN);
		$this->style_auto();
		$this->login_token();
		$this->sessionid();
		if(!isset ($_COOKIE["cookie_warning"]) and isset($_COOKIE["cookie_active"])){
			setcookie("cookie_warning",true, time()+60*60*7, FW_COOKIE_PATH, FW_COOKIE_DOMAIN);
		}
	}
	
	function style_auto(){
		//not used - style is not determined by cookies
			global $settings;
			if (isset ($_POST["select_style"])){
				$style = $_POST["select_style"].".css";
				$_SESSION["style_set"] = $style;
				setcookie("style_set", $style, time()+(60*60*24*7), FW_COOKIE_PATH, FW_COOKIE_DOMAIN);
			}
			//
			$default_style = $settings['default_style'];//<-- analysis if mobile desktop or responsive
		
			if (!isset ($_COOKIE["style_set"])){
				/*
				
				disabled
				
				if (@$_GET["new_style"]!="start" and @$_COOKIE["cookie_active"] == 1){
					//header('location:'.$_SERVER['PHP_SELF'].'?new_style=start');
				}
				if (@$_GET["new_style"]=="start"){
					if (find_mobile_browser(false)==true)
					{
						setcookie("style_set",$default_style.".css", time()+60*60*24*7);
					}
					else{
						setcookie("style_set",$default_style.".css", time()+60*60*24*7);
					}		
					//header('location:'.$_SERVER['PHP_SELF']);
				}
				*/
				
			}
		}
		
	function login_token(){
			if (isset ($_SESSION["loginkey"]) and !isset ($_COOKIE["loginkey"]) and @$_SESSION["loginkey_active"] == 1)
			{
				setcookie("loginkey",$_SESSION["loginkey"], time()+60*60*24*14, FW_COOKIE_PATH, FW_COOKIE_DOMAIN);
				}
			elseif (isset ($_SESSION["loginkey"]) AND @$_SESSION["loginkey_active"] == 0)
				{
					unset ($_SESSION["loginkey_active"]);
				}
			}
	function sessionid(){
		if (!isset ($_COOKIE["sessionid"])){
			if (version_compare(PHP_VERSION, '7.0.0') >= 0){
				setcookie("sessionid",random_int(100, 999), time()+60*10, FW_COOKIE_PATH, FW_COOKIE_DOMAIN);
							}
			else{
				setcookie("sessionid",rand(100, 999), time()+60*10, FW_COOKIE_PATH, FW_COOKIE_DOMAIN);
			}
			/*$sessionid=date(dm).random_int(100, 999);
			setcookie("sessionid",$sessionid, time()+60*10);*/
		}
	}
			
	function check()
	{
		if (@$_COOKIE["cookie_active"] == 1){
			return true;
		}	
		elseif (@$_GET["cookie_active"]=="false")
		{
			return false;
		}
		else
		{
			return NULL;
		}
	}
	
	function hint(){
		if (@$_COOKIE["cookie_active"] == 1){
			if (!isset ($_COOKIE["cookie_warning"]) or !isset ($_COOKIE["cookie_agreed"])){
				if(find_mobile_browser()===true){
					$ext_style="width:100%;";
				}
				else{
					$ext_style="padding-left:1%;padding-right:1%;";
				}
				echo"
				<div id='cookie_hint' style='background-color: rgba(190, 190, 190, 0.92);position:fixed;bottom: 0;z-index: 10;width: 100%;'>
				<b>Verwendung von Cookies</b>
				<br>Da in Ihren Browser-Einstellungen Cookies aktiviert sind und Sie die Webseite weiter nutzen, stimmen Sie der Verwendung von Cookies zu.
				<br><a href='".FW_CLIENT_ROOT."disclaimer.html' class='link' target='_blank'>Weitere Informationen</a> zu Haftungsausschluss & Datenschutz.
				<a class='button' style='$ext_style' onclick=\"toggle('cookie_hint');setCookie('cookie_agreed',1,'1');\">OK</a>
				
				</div>
				";		
			}
		}	
	}
}
		

?>