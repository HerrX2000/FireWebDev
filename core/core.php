<?php
/**
 * FireWeb webbased software series
 * Copyright 2014-2017 Frederik Mann, All Rights Reserved
 *
 * Released under the GNU license
 * License: http://www.gnu.org/licenses/
 **/
$STARTTIME = microtime(true);
header("Content-Type: text/html; charset=utf-8");
//define Page Values
define("FW_CORE_VERSION", "0.7.2");
define("FW_CORE_VERSION_STATUS", "");
define("FW_CORE_API", "7");
//Include
require_once("global.php");
require(FW_ROOT."/inc/include.php");
//Cookie
$cookie = new cookie;
$cookie->run();

//HEADER_SEND

if(!include_once FW_ROOT."/module/".FW_MODULE."/include.php"){
	require_once FW_ROOT."/module/core/include.php";
}
header_script();
module_header_script();
 ?>
<!doctype html>
<html <?php echo "lang='".FW_LANG."'"; ?>>
<head>
	<?php
		head_script();
		$cookie->check();
	?>
	<meta charset="utf-8">
	<meta name="description" content="<?php	echo meta_description(); ?>">
	<meta name="keywords" content="<?php echo meta_keywords(); ?>">
	<meta name="robots" content="<?php	echo meta_robots(); ?>">
	<meta http-equiv="x-ua-compatible" content="IE=EDGE"> 
	<link rel="shortcut icon" type="image/x-icon" href="images/favicon/favicon.ico">
	<link rel="icon" type="image/x-icon" href="images/favicon/favicon.ico">
	<link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png">
	<link rel="manifest" href="images/favicon/manifest.json">
	<meta name="theme-color" content="#a06429">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--high priority scripts-->
	<link rel="stylesheet" type="text/css" href="inc/style/fw_basic.css">
	<?php 
	if(!isset($_SESSION["username"])){
	echo"<!-- Global Site Tag (gtag.js) - Google Analytics -->
	<script async src=\"https://www.googletagmanager.com/gtag/js?id=UA-107717261-1\"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());
	gtag('config', 'UA-107717261-1');
	</script>
	";
	}
	?>
	<title><?php show_head_title(); ?></title>

</head>
<body>
<!--[if lte IE 8]>
<div id="warning" style="position:fixed;bottom:0;right:0;z-index:100;background:white;">
<h1 style="color:red;">Ihr Browser (IE 8 oder älter) wird nicht unterstützt!</h1>
<p>Bitte wechseln Sie zu <a href="https://www.google.com/chrome/browser/">Chrome</a> oder <a href="http://getfirefox.com">Firefox </a> | <a href="#" onClick="document.getElementById('warning').style.display = 'none';"><b>Schließen</b></a></p>
</div>
<![endif]-->
<!--[if gte IE 9]>
<p style="color:red;position:fixed;bottom:0;right:0;z-index:100;background:white;" id="warning">Bitte wechseln Sie zu <a href="https://www.google.com/chrome/browser/">Chrome</a> oder <a href="http://getfirefox.com">Firefox </a> |  <a href="#" onClick="document.getElementById('warning').style.display = 'none';"><b>Schließen</b></a></p>
<![endif]-->
	<div id="menu_fixed">
		<?php
		show_menu();
		?>
	</div>
	<?php
	$cookie->hint();
	?>
	<div class="header">
		<?php 
			show_header();
			if (basename($_SERVER['SCRIPT_NAME']) != "login.php")
			{
			show_status();
			}		
			?>
	</div>
	<div class="background"></div>
	<div class="middle">
		<div class="top">
			<nav class="menu">
				<?php
				show_menu();
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
			<div class="container_center">
				<?php
				content_main();		
				?>
			</div>
			<?php
			if (FW_MODULE_MATERIAL_BUTTON == true){
				echo "<a href='".@FW_MODULE_MATERIAL_BUTTON_LINK."' class=\"material_button\"><img style=\"height:90%;padding-top:5%;auto;\" alt=\"info\" src=\"images/icons/material_button.png\"></a>";
			}
			?>
		</div>
	</div>
	<div class="credits">
		<?php show_credits();?>
	</div>
	<footer class="footer" style='text-align:right'>
		<span><?php footer_show_style();?></span>
		<?php footer_show_w3c();?>
		<br>
		<?php footer_show_version();?>
		<br><b>Powered by  <a href='' class="link_accent">FireWeb</a> </b>
	</footer>
	<!--low priority scripts-->
	<link rel="stylesheet" type="text/css" href="<?php show_style();?>">
	<?php
	if (show_style_sub()!=""){
		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"". show_style_sub()."\";>
		";
	}
	echo module_footer_script();
	?>
	<script type="text/javascript" src="inc/library/js.inc.js"></script>
<?php
show_note();
$ENDTIME = microtime(true);
$RUNTIME = $ENDTIME - $STARTTIME;
$RUNTIME = round ($RUNTIME, 3);
$RUNTIME_MS = $RUNTIME * 1000;
$USERAGENT = $_SERVER['HTTP_USER_AGENT'];
$SCRIPT_NAME = basename($_SERVER['SCRIPT_NAME']);
$SCRIPT_PARENT = dirname($_SERVER['SCRIPT_NAME']);

if(isset ($_GET['p'])){
	$SCRIPT_NAME = $SCRIPT_NAME."?p=".$_GET['p'];
}
if(isset ($_GET['r'])){
	$SCRIPT_NAME = $SCRIPT_NAME."&r=".$_GET['r'];
}
//
statistics_collector($SCRIPT_NAME, $USERAGENT, $RUNTIME_MS, $SCRIPT_PARENT);
//
print "
<!--
Build-up time: $RUNTIME_MS ms
Useragent: $USERAGENT
Page: $SCRIPT_NAME
Parent: $SCRIPT_PARENT

Statistics are anonymously saved in a local database and are not shared automatically with any 3rd parties.
If cookies are enabled an anonymous SessionID is created for less than an hour.
-->";

if(@$_SESSION["admin"] === "1"){
	$query_count = $db_my->query_count;
$query_time = $db_my->query_time;
$query_strings= $db_my->query_strings;
echo"
<!--
Querys: $query_count
Querytime: $query_time ms?
Querys:
	";
foreach ($query_strings as $query_string){
	echo $query_string."
	";
}
echo"
-->";
}
?>