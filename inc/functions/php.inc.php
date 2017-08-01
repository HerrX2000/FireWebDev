<?php

/**
 * FireWeb webbased software series
 * Copyright 2017 Frederik Mann, All Rights Reserved
 *
 * License: http://www.gnu.org/licenses/
 *
**/
/**
 *Core-FireWeb PHP Function Library
**/
//!Header
$error_report=1;
//
//
if ($error_report==2){
error_reporting(E_ALL);
if (!ini_get('display_errors')) {
			ini_set('display_errors', '1');
}
}
elseif($error_report==1){
error_reporting(E_ERROR | E_WARNING | E_PARSE);
if (!ini_get('display_errors')) {
			ini_set('display_errors', '1');
}	
}
else{
error_reporting(0);
}

$path = realpath(dirname(dirname(__FILE__)). '/../');
require_once $path."/global.php";
//!Global-Werte

if (@version_compare(FW_PAGE_VERSION, '0.6.9a1', '<') or  NULL === FW_PAGE_VERSION	){
	define ('FW_PAGE_VERSION_OLD', true);
}

//Online/Offline

function header_script(){
	if (isset($_COOKIE["loginkey"]) and !isset ($_SESSION["username"])){
		$loginkey=$_COOKIE["loginkey"];
		if (class_exists('user_login_token')){
			$header_loginkey= new user_login_token;
			$header_loginkey->user_login_token_verify($loginkey);
		}
	}
}
function head_script(){
	
}
function show_status($disabled = ''){
		if($disabled != true){
			global $db_my;
			global $settings;
			//$db_my->query("SET NAMES 'utf8'", $hide_errors=0, $write_query=0);
			$status=$settings['status'];
			
			if($settings['status'] == 0 and isset ($_SESSION["username"])){ 
				echo "<p style='text-align:center;'>Wartungsarbeiten</p>";
			}
			elseif($settings['status'] == 0 and !isset ($_SESSION["username"])){
				$status_reason=$db_my->query("SELECT name, value FROM ". $db_my->prefix ."settings WHERE name LIKE 'status_reason'", $hide_errors=0, $write_query=0);
				$status_reason = $db_my->fetch_assoc($status_reason); 
				echo "<div class='background'></div><div class='content' style='height:300px;overflow-y:auto;margin-top:40px;'><div style='text-align:center;'><h1>Offline</h1></div>";
				echo $status_reason ['value'];
				echo "<h4>Es kann zum Totalausfall der Website kommen</h4>
				";
				echo "</div><div class='content' style='text-align:center;'><h3>Login</h3>
				<form name='login' action='login.php?processed=1' method='post'>
				<input type='text' placeholder='Benutzername' size='24' maxlength='150'
				name='username'><br>
				<input placeholder='Passwort' type='password' size='24' maxlength='50'
				name='password'><br>
				<p class='nodisplay'>
				<label for='email2'>E-Mailbestätigung (leer lassen):</label>
				<input id='email2' name='email2' size='60' value='' />
				</p>
				<input type='submit' style='position: absolute; left: -9999px; width: 1px; height: 1px;'/>
				<br></form>
				<a href='#' onclick='document.login.submit();' class='button'>Login</a> 
				<a href='#'  onClick='alert('Nicht verfügbar') class='button'>Registrieren</a>
				</div>";
				exit;
			}
		}
	}
function edit_status(){
		global $db_my;
		//
		$status = $_POST["status"]; 
		$grund = $_POST["grund"];
		$status =$db_my->escape_string($status);
		$grund = $db_my->escape_string($grund);
		//
		if ($status != "" and $grund != ""){
			$db_my->query("UPDATE ". $db_my->prefix ."settings SET value='$status' WHERE name='status'");
			echo"Status:";
			if ($status==1)
			{
				echo "Online";
			}
			else{
				echo "Offline";
			}
			echo"<br>";
			$db_my->query("UPDATE ". $db_my->prefix ."settings SET value='$grund' WHERE name='status_reason'", $hide_errors=0, $write_query=0);
			echo"<textarea cols='30' rows='10' readonly>Grund: $grund</textarea>";
		}
	}

	


//Titel
function show_header(){
	global $settings;
		$page_name = $settings['page_name'];
		$home_name = $settings['home_name'];
		$home_url = $settings['home_url']; 
		if($home_name != "" and $page_name == $home_name){
			echo"<p><span style='font-size:x-large;margin-left:10%;'><a href='index.php' class='link'><b>".$page_name."</b></a></span></p>";
		}
		else{
			echo"<p><span style='font-size:x-large;margin-left:10%;'>
			<a href='".$home_url."'>
			<img hreflang='de' src='images/icons/home.png' alt='Home' style='height:22px;width:22px'/></a>
			<a href='index.php' class='link'><b>".$page_name."</b></a></span></p>";
		}
}
	function show_title()
	{
		global $settings;
		$page_name = $settings['page_name'];
		$home_name = $settings['home_name'];
		$home_url = $settings['home_url']; 
		if($home_name != "" and $page_name == $home_name){
			echo"<p><span style='font-size:x-large;margin-left:10%;'><a href='index.php' class='link'><b>".$page_name."</b></a></span></p>";
		}
		else{
			echo"<p><span style='font-size:x-large;margin-left:10%;'>
			<a href='".$home_url."'>
			<img src='images/icons/home.png' alt='Home' style='height:22px;width:22px'/></a>
			<a href='index.php' class='link'><b>".$page_name."</b></a></span></p>";
		}		
	}
	
	//Experimental auto_menu
	function detect_tables($table=""){
			global $db_my;
			$query="SHOW TABLES LIKE '%".$table."%'";
			//
			$result=$db_my->query($query, $hide_errors=0, $write_query=0);			
			//
			$table_area_list = array();
			while ($row = $db_my->fetch_array($result,  $resulttype=MYSQLI_NUM))
			{
				array_push ($table_area_list, $row[0]);				
			}
			return $table_area_list;		
		}
	
	function show_menu()
	{
		if (function_exists('show_menu_modul')){
			show_menu_modul();
		}
		else{
		$area = detect_tables($table="area_");
		$area = str_replace("area_","",$area);
		$entries = detect_tables($table="entries_");
		$entries = str_replace("entries_","",$entries);
		if (find_mobile_browser(false)==true)echo "
		
		<a href='entries.php?p=".$entries [0]."' style='width:33%;height:100%;line-height:78px;font-size:1.1em;' class='button_theme'>News</a>
		<a href='area.php?p=".$area [0]."' style='width:33%;height:100%;line-height:78px;font-size:1.1em;' class='button_theme'>Über uns</a>
		<a href='area.php?p=".$area [0]."&r=Discord' style='width:33%;height:100%;line-height:78px;font-size:1.1em;' class='button_theme'>Support</a>
		<!--<a href='http://fireweb.blackburn-division.de/' style='width:25%;height:100%;line-height:78px;font-size:1.1em;' class='button_theme'>FireWeb</a>-->
";
		else echo "
		<a href='entries.php?p=".$entries [0]."' style='width:20%;height:100%;line-height:78px;font-size:1.1em;' class='button_theme'>News</a>
		<a href='area.php?p=".$area [0]."' style='width:20%;height:100%;line-height:78px;font-size:1.1em;' class='button_theme'>Über uns</a>
		<a href='area.php?p=".$area [0]."&name=Discord' style='width:20%;height:100%;line-height:78px;font-size:1.1em;' class='button_theme'>Support</a>
		<!--<a href='http://fireweb.blackburn-division.de/' style='width:15%;height:100%;line-height:78px;font-size:1.1em;' class='button_theme'>FireWeb</a>-->
		";
		}
	}
	

	
	function content_right_calender()
	{
		echo "
		<h5><a class='link' href='calendar.php'>Event-Kalender</a></h5>";
		show_calendar_js();
		echo "<br>";
	}
	
	function content_right_contact()
	{
		echo "
		<a href='page.php?p=Impressum' class='button'><p><b>Kontakt</b></p></a>
		";
	}
	
	function show_credits()
	{
		echo "<a href=\"page.php?p=Impressum\" class=\"link\" style=\"margin-right:10%;\">Impressum</a> 
		<a class=\"link\" style=\"margin-left:10%;\">Powered by FireWeb</a>";
	}
	
	function show_note()
	{
		echo "
<!--
		English
FireWeb is a Content Managment System under development.

Copyright (C) 2014-2017 Frederik Mann

This program is under the GNU General Public License, see <http://www.gnu.org/licenses/>.
		
The source code is available via Github@FireWebDev.

Thanks to the Notepad++ Team!
Thanks to the XAMPP Team!
-->
"
;
	}
//Stand not in use
		function footer_show_modified()
		{
		global $fw_modified;
		echo "Stand: $fw_modified";
		}
//Stand
		function footer_show_version()
		{
			if (version_compare(FW_VERSION, FW_CORE_VERSION, '=')){
			$fw_version= FW_VERSION;
			}
			elseif (version_compare(FW_VERSION, FW_CORE_VERSION, '<')){
			$fw_version= "<font color='green'>". FW_VERSION ."</font>";
			}
			elseif (version_compare(FW_VERSION, FW_CORE_VERSION,  '>')){
			$fw_version= "<font color='red'>". FW_VERSION ."</font>";
			}
			
			else {
				$fw_version="undefined";
			}
			
			if(FW_VERSION_STATUS!="")
			{
				$fw_version = $fw_version."(".FW_VERSION_STATUS.")";
			}				
	
		echo "Version <a href='changelog.html' class='link_accent'>$fw_version</a> ";
		}		

//Style
	function footer_show_style(){
		if (isset($_COOKIE["style_set"])){
			$style=$_COOKIE["style_set"];
			$style=basename($style,".css");
		}
		else{
			global $settings;
			$style=$settings['default_style'];
		}
		
		if (file_exists ("inc/style/".$style.".xml")){
			$xml_file=simplexml_load_file("inc/style/".$style.".xml");
			echo "Style: ".	$xml_file->name ."<!-- ". $xml_file->version . "Under FireWeb:". $xml_file->fwversion . " API" . $xml_file->api .  "-->";
		}
		else{
				 echo "Style: ".$style;
		}
	}		
	

//Function w3c
		function footer_show_w3c(){
		$dateiname=$_SERVER['SCRIPT_NAME'];  
		$path = pathinfo($dateiname);
		echo "
		<a style='float:left;' class='link' href='http://validator.w3.org/check?uri=http://".$_SERVER['SERVER_NAME']."/".$path["basename"]."' target='_blank'>
		<img src='images/icons/html5.png' alt='W3C'> 
		</a> "
		;
		}
//Function Titel	use unknown
	
		function show_head_title(){
		global $settings;
		if (function_exists('file_title'))
		{
		$file_title = file_title();
		}
		else{
		$dateiname=$_SERVER['SCRIPT_NAME'];  
		$path = pathinfo($dateiname);
		$path["filename"]= ucfirst($path["filename"]);
		$file_title = $path["filename"];
		}
		echo $settings['page_name']." - ".$file_title;
		}
		
	
		
//Function Datei_include
		/*function file_include(){
		$dateiname=$_SERVER['SCRIPT_NAME'];  
		$path = pathinfo($dateiname);
		if (version_compare(FW_VERSION, '0.6.9', '<'))
		{
			echo "Version veraltet";
			include $path["filename"].".inc.".$path["extension"];
		}
		modul_include();
		///modul is automaticly include by inc/include.php
		}*/


		
//! PHP Include Functions

//STAT Frame start
include_once (FW_ROOT."/inc/functions/lb_statistics.php");

//STAT Frame end

			
//SHOW/EDIT/REMOVE/DELETE Section

//entries start
include_once (FW_ROOT."/inc/functions/lb_entries.php");
//entry		
include_once (FW_ROOT."/inc/functions/lb_entry.php");
//Entries end
//area start
include_once (FW_ROOT."/inc/functions/lb_area.php");
//area end
//comments
include_once (FW_ROOT."/inc/functions/lb_comments.php");
//comments end
//calendar
include_once (FW_ROOT."/inc/functions/lb_calendar.php");
//calendar end
//page 
include_once (FW_ROOT."/inc/functions/lb_page.php");
//page end
function show_settings_entries($target){
		//////////////////////
		//					//
		//	List Settings	//
		//					//
		//////////////////////
		global $db_my;
		// 
		//$db_my->query("SET NAMES 'utf8'", $hide_errors=0, $write_query=0);
		//
		$query="SELECT id,name,title,value from ". $db_my->prefix ."settings ORDER BY id ASC";

		//
		$result=$db_my->query($query, $hide_errors=0, $write_query=0);			
		//
		
		echo "<table id='settings' style='width:100%;border-style:solid;border-color:#D3D3D3;border-collapse: collapse;border-width: 1px;'>";
			
		while ($row = $db_my->fetch_assoc($result)){
			$rows[] = $row ;
		}
		foreach($rows as $row){
			echo "<tr>";
			echo "<td style='border-style:solid;border-color:#585858;border-width: 1px;'><span id='tooltip'><a href='#' class='link'><b>".$row['title']."</b><span>".$row['name']."</span></span></td>";
			echo "<td style='border-style:solid;border-color:#585858;border-width: 1px;height:54px;'>".$row['value']."</td>";
			echo "<td style='border-style:solid;border-color:#585858;border-width: 1px;width:33px;'>
			<form name='aendern_start' action='?p=$target&id=".$row["id"]."' method='post'>
			<input type='hidden' name='id' value='".$row['id']."'>
			<input type='hidden' name='name' value='".$row["name"]."'>
			<input type='hidden' name='title' value='".$row["title"]."'>
			<input type='hidden' name='value' value='".$row["value"]."'>
			<input type='image' src='images/icons/edit.png' style='wdith:32px;height:32px;' alt='edit_event'>			
			</form>
			</a></b></td>";
			echo "</tr>";			
		}			
		echo"</table>";
}
function edit_settings_entry($id,$value){
			global $db_my;
			//
			$id = $db_my->escape_string($id); 
			$value = $db_my->escape_string($value);
			//
			if($db_my->query("UPDATE ". $db_my->prefix ."settings SET value='$value' WHERE id='$id' or name='$id'")){
				return true;
				//allways returns true 
			}
}
function create_table($type, $name, $menu_entry){
			global $db_my;
			if($type=="" or $name==""){
				exit;
			}
			//
			$type = $db_my->escape_string($type); 
			$name = $db_my->escape_string($name);
			//
			if($type=="entries"){
				$query="CREATE TABLE IF NOT EXISTS`".$db_my->prefix."entries_$name` (
				  `id` int(11) NOT NULL,
				  `content` text COLLATE utf8_bin NOT NULL,
				  `autor` varchar(30) COLLATE utf8_bin NOT NULL,
				  `removed` int(1) NOT NULL DEFAULT '0'
				) DEFAULT CHARSET=utf8 COLLATE=utf8_bin;";
				if(!$db_my->query($query,1)){
					echo "<br>Create Table failed: (" . $db_my->errno() . ") " . $db_my->error_string();
				}
				
				$query = "ALTER TABLE `".$db_my->prefix."entries_$name`
				 ADD PRIMARY KEY (`id`),
				 ADD KEY `id` (`id`),
				 CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;
				";
				if(!$db_my->query($query,1)){
					echo "<br>Alter Table failed: (" . $db_my->errno() . ") " . $db_my->error_string();
					exit;
				}
			}
			
			elseif($type=="area"){
				$query="CREATE TABLE`".$db_my->prefix."area_$name` (
				  `id` int(11) NOT NULL,
				  `name` varchar(120) NOT NULL,
				  `title` varchar(120) NOT NULL,
				  `content` text NOT NULL,
				  `modifiable` int(1) NOT NULL DEFAULT '1'
				) DEFAULT CHARSET=utf8;";
				if(!$db_my->query($query,1)){
					echo "<br>Create Table failed: (" . $db_my->errno() . ") " . $db_my->error_string();
					exit;
				}
				$query="ALTER TABLE `".$db_my->prefix."area_$name`
				 ADD PRIMARY KEY (`id`),
				 CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT;
				";
				if(!$db_my->query($query,1)){
					echo "<br>Alter Table failed: (" . $db_my->errno() . ") " . $db_my->error_string();
					exit;
				}
			}
			echo "<br>Tabelle erfolgreich erstellt";
			if($menu_entry==true){
				global $settings;
				$value= $settings['menu_order'].",$name=$type=$name ";
				if(edit_settings_entry("menu_order",$value)){
					echo "<br>Menü-Eintrag erfolgreich erstellt";
				}
			}
}
function remove_table($type, $name, $delete){
			global $db_my;
			if($type=="" or $name==""){
				exit;
			}
			//
			$type = $db_my->escape_string($type); 
			$name = $db_my->escape_string($name);
			$delete = $db_my->escape_string($delete);
			//
			if($delete==true){
				delete_table($type, $name);
			}
			else{
				$query="RENAME TABLE `".$db_my->prefix."$type"."_$name` TO `".$db_my->prefix."removed_".$type."_$name`;";
				if(!$db_my->query($query)){
					echo "<br>Remove Table failed: (" . $db_my->errno() . ") " . $db_my->error_string();
					exit;
				}
				echo "<br>Tabelle erfolgreich entfernt";
				return true;
			}
			
	}

function delete_table($type, $name){
			global $db_my;
			if($type=="" or $name==""){
				exit;
			}
			//
			$type = $db_my->escape_string($type); 
			$name = $db_my->escape_string($name);
			//
			$query="DROP TABLE `".$db_my->prefix."$type"."_$name`";
			if(!$db_my->query($query)){
				echo "<br>Delete Table failed: (" . $db_my->errno() . ") " . $db_my->error_string();
				exit;
			}
			echo "<br>Tabelle erfolgreich gelöscht";
}
///Add/Show/Remove/Delete Section End	
//////////////////////////////////////////
///Cookie/Style Section
include_once (FW_ROOT."/inc/functions/lb_cookie.php");
///Cookie end
		
function style_sub(){
	global $settings;
	$style = $settings['default_style'];
	if (strpos($style, '@') !== false){
		$styles = explode("@", $style);
		return $styles;
	}
	else{
		return false;
	}
}
function show_style(){
	global $settings;
	if (style_sub()==false){
		$style = $settings['default_style'];//<-- analysis if mobile desktop or responsive
	}
	else{
		$styles=style_sub();
		$style=$styles[0];
	}
	echo FW_CLIENT_ROOT."inc/style/$style.css";
}
function show_style_sub(){
	global $settings;
	if (style_sub()==false){
		return false;
	}
	else{
		$styles=style_sub();
		$style=$styles[1];
	}
	echo FW_CLIENT_ROOT."inc/style/sub/$style.css";
}
		/*
		if (isset ($_COOKIE["style_set"])){
		echo FW_CLIENT_ROOT."inc/style/".$_COOKIE["style_set"];
		}
		elseif (find_mobile_browser(false)==true){
		echo FW_CLIENT_ROOT."inc/style/default_mobile.css";
		}
		else{
			$default_style= $settings['default_style'].".css";//should come from db
			echo FW_CLIENT_ROOT."inc/style/$default_style";
		}
		*/
?>