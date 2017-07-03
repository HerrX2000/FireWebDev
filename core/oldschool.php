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
define("FW_PAGE_VERSION", "0.6.9");
define("FW_PAGE_API", "7");
//Include
require_once("global.php");
require("inc/functions/fw_users.inc.php");
require(FW_ROOT."/inc/include.php");
?>
<?php
		cookie();
		header_script();
//HEADER_SEND
?>
<!doctype html>
<html>
<head>
<?php
		head_script();
		check_cookie();
		?>
<meta charset="utf-8">
<meta name="description" content="<?php	meta_description(); ?>">
<meta name="keywords" content="<?php meta_keywords(); ?>">
<meta name="robots" content="<?php meta_robots(); ?>">
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
<link rel="stylesheet" type="text/css" href="inc/functions/calendar/calendar.css">
<link rel="stylesheet" type="text/css" href="inc/style/fw_basic.css">	
<link rel="stylesheet" type="text/css" href="<?php style_set();?>">
<!--[if lt IE 7]>
<style type="text/css">@import url(style_simple.css);</style>
<![endif]-->
<?php modul_include(); ?>
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
<nav id="menu_fixed">
		<?php
		menu();
		?>
</nav>
<div class="header">
	<?php 


	/*
	$id = "1";
	$id = $db->escape_string($id);
	$query = $db->query("SELECT * FROM `blog` WHERE id = '1'", $hide_errors=0, $write_query=0);
	while ($row = $db->fetch_assoc($query))
			{
			$rows[] = $row;
			}
			foreach($rows as $row){
			echo $row['content'];
			}
			
		$db->close();
	if ($db->connect($config)->query("INSERT INTO `content_news` (`id`, `content`, `autor`, `removed`) VALUES (NULL, 'Und?', 'd', '0')")) {
    printf("Table myCity successfully created.\n");
	}*/
		titel();
	?>

<?php
		if (basename($_SERVER['SCRIPT_NAME']) != "login.php")
		{
		status();
		}		
		?>
</div>
<div class="background"></div>
<div class="middle">
<div class="top">
<nav class="menu">
		<?php
		menu();
		?>
</nav>
<div class="content_top">
		<?php
		content_top();	
		?>
</div>
</div>
	
    <div class="container">
	<div class="container_left">
		<?php
		container_left();
		?>
	</div>
	<div class="container_right">
		<?php
		container_right();
		?>
	</div>
		<?php
		content_main($db_link_i);		
		?>
	</div>
</div>
<div class="credits">
<?php credits();?>
</div>
<footer class="footer" style='text-align:right'>
<span><?php footer_style();?></span>
<br	/>
<?php footer_w3c();?>
<?php footer_version();?>
<br><b>Powered by  <a href='http://fireweb.blackburn-division.de/' class="link_accent">FireWeb</a> </b>
</footer>
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