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

/*if (@version_compare(FW_PAGE_VERSION, '0.6.9a1', '<') or  NULL === FW_PAGE_VERSION	){
	define ('FW_PAGE_VERSION_OLD', true);
}*/

//Online/Offline

//CORE Frame start
include_once (FW_ROOT."/inc/functions/lb_core.php");
//CORE Frame end

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
//settings 
include_once (FW_ROOT."/inc/functions/lb_settings.php");
//settigns end

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