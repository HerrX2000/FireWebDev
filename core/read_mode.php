<?php
/**
 * FireWeb webbased software series
 * Copyright 2014-2016 Frederik Mann, All Rights Reserved
 *
 * License: http://www.gnu.org/licenses/
 *
 **/

$STARTTIME = microtime(true);
?>
<?php
header("Content-Type: text/html; charset=utf-8");
?>
<?php
//define Page Values
define("FW_PAGE_VERSION", "0.6.9b4");
define("FW_PAGE_API", "7");
//Include
require_once("global.php");
require("inc/functions/fw_users.php");
require(FW_ROOT."/inc/include.php");
if(!include_once FW_ROOT."/modul/".FW_MODUL."/include.php"){
	require_once FW_ROOT."/modul/core/include.php";
}
?>
<?php
		$cookie = new cookie;
$cookie->run();
		header_script();
//HEADER_SEND
?>
<!doctype html>
<html>
<head>
<?php
		head_script();
		$cookie->check();
		?>
<meta charset="utf-8">
<meta name="description" content="<?php	echo meta_description(); ?>">
<meta name="keywords" content="<?php echo meta_keywords(); ?>">
<meta name="robots" content="<?php echo meta_robots(); ?>">
<link rel="manifest" href="/icon/manifest.json">
<!--[if IE]><link rel="shortcut icon" href="/icon/favicon.ico"><![endif]-->
<!-- Touch Icons - iOS and Android 2.1+ 180x180 pixels in size. --> 
<link rel="apple-touch-icon-precomposed" href="icon/android-icon-180x180.png">
<!-- Firefox, Chrome, Safari, IE 11+ and Opera. 196x196 pixels in size. -->
<link rel="icon" href="icon/android-icon-196x196.png">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-TileImage" content="/icon/ms-icon-144x144.png">
<meta name="theme-color" content="#0F2104">
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" type="text/css" href="inc/calendar.css">
<link rel="stylesheet" type="text/css" href="inc/style/style.css">
<!--[if lt IE 7]>
<style type="text/css">@import url(style_simple.css);</style>
<![endif]-->
<title>7.bd/<?php
if (function_exists('datei_titel'))
		{
		datei_titel();
		}
		else
		{
		$dateiname=$_SERVER['SCRIPT_NAME'];  
		$path = pathinfo($dateiname);
		$path["filename"]= ucfirst($path["filename"]);
		echo $path["filename"];
		}
		?></title>
</head>
<body>
<div class="middle" style="min-height:0;margin-top:-24px;padding-top:4px;padding-bottom:4px;margin-bottom:-12px;">
		<a href="#" target="_blank">
		</a>
		<?php
		content_main();		
		?>
</div>
<div class="credits" style="padding:0px;">
<a href="http://fireweb.blackburn-division.de/" class="link">Powered by FW´s Read_mode</a>
</div>
<script type="text/javascript" src="inc/js.inc.js"></script>
<?php note();?>
<?php 
$ENDTIME = microtime(true);
$RUNTIME = $ENDTIME - $STARTTIME;
$RUNTIME = round ($RUNTIME, 3);
$RUNTIME_MS = $RUNTIME * 1000;
$USERAGENT = $_SERVER['HTTP_USER_AGENT'];
$SCRIPT_NAME = basename($_SERVER['SCRIPT_NAME']);
$SCRIPT_PARENT = dirname($_SERVER['SCRIPT_NAME']);
$query_count = $db_my->query_count;
$query_time = $db_my->query_time;
$query_strings= $db_my->query_strings;
print "
<!--
Seitenaufbaudauer: $RUNTIME_MS ms
Useragent: $USERAGENT
Page: $SCRIPT_NAME
Parent: $SCRIPT_PARENT
Querys: $query_count
Querytime: $query_time ms?

-->";

if($_SESSION["admin"] == "1"){
echo"
<!--
Querys:	";
foreach ($query_strings as $query_string){
	echo $query_string."
	";
}
echo"
-->";
}
statistics_collector($SCRIPT_NAME, $USERAGENT, $RUNTIME_MS, $SCRIPT_PARENT);
?>