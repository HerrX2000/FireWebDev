<?php
/**
 * FireWeb webbased software series
 * Copyright 2014-2016 Frederik Mann, All Rights Reserved
 *
 * License: http://www.gnu.org/licenses/
 *
 */
///Init Include current selected file end
function detect_menu_order(){
	global $settings;
	$menu_order=array();
	$menu_items = explode(",", $settings['menu_order']);
	foreach ($menu_items as $menu_item){
		$menu_item = explode("=", $menu_item);
		if(count($menu_item)!=3){
			echo"Fehler in Einstellung Titel Class oder ID nicht definiert";
			return;
		}
		$menu_item_title = $menu_item[0];
		$menu_item_class = $menu_item[1];
		$menu_item_name = $menu_item[2];
		//$menu_item_value=detect_tables($table=$menu_item_class."_");
		//$menu_item_value = str_replace($menu_item_class."_","",$menu_item_value);
		//$menu_item [2]= $menu_item_value[$menu_item_id];
		//returns 'array id' instead of 'class name'
		/////////////////////////////////////////////////////////////
		array_push($menu_order,$menu_item);
		
	}
	return $menu_order;
}

function show_menu_modul(){
	$menu_order = detect_menu_order();
	$menu_order_count = count($menu_order);
	if (find_mobile_browser(false)==false){$element_width = 80/$menu_order_count;}
	else {$element_width = 100/$menu_order_count;}
		foreach ($menu_order as $menu_item){
			if($menu_item[1]=="url"){
				echo"<a href='".$menu_item[2]."' style='width:$element_width%;height:100%;line-height:78px;font-size:1.1em;margin:0px;' class='button_theme'>".$menu_item[0]."</a>";	
			}
			else{
				echo"<a href='".$menu_item[1].".php?p=".$menu_item[2]."' style='width:$element_width%;height:100%;line-height:78px;font-size:1.1em;' class='button_theme'>".$menu_item[0]."</a>";
			}
		}
	
	
	echo "<a href='comment.php?r=bug_report&site=".basename($_SERVER['PHP_SELF'])."' onclick=\"alert('Bugreport');\">
		<img src='images/icons/bug_report.png' alt='Bugreport' style='height:39px;width:39px'/></a>";
	//echo "<a href='administration.php?p=edit_settings' style='float:right;'><img src='images/icons/settings.png' style='width:78px;height:78px;' alt='manager_area'></a>";
	/*
	$area = detect_tables($table="area_");
		$area = str_replace("area_","",$area);
		$entries = detect_tables($table="entries_");
		$entries = str_replace("entries_","",$entries);
		if (find_mobile_browser(false)==true)echo "
		<a href='entries.php?p=".$entries [0]."' style='width:25%;height:100%;line-height:78px;font-size:1.1em;' class='button_theme'>Über mich</a>
		<a href='area.php?p=".$area [0]."' style='width:25%;height:100%;line-height:78px;font-size:1.1em;' class='button_theme'>Praktiken</a>
		<a href='area.php?p=".$area [0]."&r=Discord' style='width:25%;height:100%;line-height:78px;font-size:1.1em;' class='button_theme'>Bilder</a>
		<a href='area.php?p=".$area [0]."&r=Discord' style='width:25%;height:100%;line-height:78px;font-size:1.1em;' class='button_theme'>Kontakt</a>
";
		else echo "
		<a href='entries.php?p=".$entries [0]."' style='width:20%;height:100%;line-height:78px;font-size:1.1em;' class='button_theme'>Über mich</a>
		<a href='area.php?p=".$area [0]."' style='width:20%;height:100%;line-height:78px;font-size:1.1em;' class='button_theme'>Praktiken</a>
		<a href='area.php?p=".$area [0]."&name=Discord' style='width:20%;height:100%;line-height:78px;font-size:1.1em;' class='button_theme'>Bilder</a>
		<a href='area.php?p=".$area [0]."&name=Discord' style='width:20%;height:100%;line-height:78px;font-size:1.1em;' class='button_theme'>Kontakt</a>
		<a href='administration.php'><img src='images/icons/settings.png' style='float:right;wdith:78px;height:78px;' alt='manager_area'></a>
		";*/
}

function meta_description(){
	global $settings;
	return $settings['meta_description'];
}

function meta_keywords(){
	global $settings;
	return $settings['meta_keywords'];
}

function meta_robots(){
			global $settings;
			return $settings['meta_robots'];
}

function container_left()
{
	echo "<div class=\"content_left\">";
	echo"<h3 style='text-align:center;'>"; 
	if(function_exists('file_title'))
	{
		echo file_title($case="head");
	}

	else
	{
		$dateiname=$_SERVER['SCRIPT_NAME'];  
		$path = pathinfo($dateiname);
		$path["filename"]= ucfirst($path["filename"]);
		echo $path["filename"];
	}
	echo"</h3> </div>";
	
	if (function_exists('content_left')) {
		content_left();
	}
	
	echo "<!-- Container_left modul/include -->";
	echo "<div class=\"content_left\">";
	if (isset($_SESSION["username"])) 
	{
		include_once FW_ROOT . '/addon/@user_pictures/init.php';
		echo "<div style=\"float:right;\">";
		at_user_pictures ($width='42px',$height='42px');
		echo "</div>";
		echo"
		<br>Hallo: <b>".$_SESSION["username"]."</b><br>";
		echo"<br>
			<a href='profil.php' class='button'>Mein Profil</a>
			<a href='logout.php' class='button'>Ausloggen</a>
			";	
	}
	
	elseif (isset($_COOKIE["loginkey"]))
	{			
		echo"
		<a href='profil.php' class='button'>Mein Profil</a>
		<a href='logout.php' class='button'>Ausloggen</a>
		";
	}
	else{
		echo"		
		<h3>Login</h3>
		<form name='login' action='login.php?processed=1' method='post'>
		<input type='text' placeholder='Benutzername' size='14' maxlength='150'
		name='username'><br>
		<input placeholder='Passwort' type='password' size='14' maxlength='50'
		name='password'><br>
		Merken: <input type='checkbox' value='1' name='loginkey_active' checked='checked'>
		<p class='nodisplay'>
		<label for='email2'>E-Mailbestätigung (leer lassen):</label>
		<input id='email2' name='email2' size='60' value='' />
		<input type='submit' style='position: absolute; left: -9999px; width: 1px; height: 1px;'/>
		</p>
		<br></form>
		<a href='#' onclick='document.login.submit();' class='button'>Login</a> 
		<a href='register.php' class='button'>Registrieren</a>
		";	
	}
	echo "</div><div class=\"content_left\">";	
	if (find_mobile_browser() == true)
	{
		echo"
		<h3><a href='calendar.php' class='button'>Event-Kalender</a></h3>";
		echo"<h3><a href='#' class='button'>Fake Button</a></h3>";
	}
	else echo"<a href='#' class='button'><p><b>Fake Button</b></p></a>";
	echo "</div>";
	echo "<!-- Container_left end -->";
}
function container_right(){
	echo"<div class=\"content_right\">";
		//show_calendar_event_next();
	echo"</div>
	<div class=\"content_right\">";
		content_right_calender();
	echo"</div>";
	
	if (function_exists('content_right')) {
		content_right();
	}
	
	echo"<div class=\"content_right\">";
		content_right_contact();
	echo"</div>";
}
function modul_header_script(){
		if (isset($_COOKIE["loginkey"]) and !isset ($_SESSION["username"])){
		$loginkey=$_COOKIE["loginkey"];
			$header_loginkey= new user_token;
			$header_loginkey->login_verify($loginkey);
	}
}
function modul_footer_script(){
echo "
<script>window.onscroll = function() {scroll_toogle ('menu_fixed',174);};</script>
<link rel='stylesheet' type='text/css' href='inc/functions/calendar/calendar.css'>
<script type='text/javascript' src='https://www.google.com/recaptcha/api.js'></script>
";
}
?>