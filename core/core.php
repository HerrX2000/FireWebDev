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
define("FW_CORE_VERSION", "0.7");
define("FW_CORE_VERSION_STATUS", "alpha");
define("FW_CORE_API", "7");
//Include
require_once("global.php");
require(FW_ROOT."/inc/include.php");
?>
<?php
	$cookie = new cookie;
	$cookie->run();
	header_script();
//HEADER_SEND
?>
<!doctype html>
<html lang="de">
<head>
<?php
	head_script();
	$cookie->check();
?>
<?php modul_include();  ?>
<meta charset="utf-8">
<meta name="description" content="<?php	echo meta_description(); ?>">
<meta name="keywords" content="<?php	echo meta_keywords(); ?>">
<meta name="robots" content="<?php	echo meta_robots(); ?>">
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
<link rel="icon" type="image/x-icon" href="./favicon.ico">
<meta name="theme-color" content="#0F2104">
<meta name="viewport" content="width=device-width,minimum-scale=1">
<!--high priority scripts-->
<link rel="stylesheet" type="text/css" href="inc/style/fw_basic.css">
<title><?php show_head_title(); ?></title>
</head>
<body>

<nav id="menu_fixed">
		<?php
		show_menu();
		?>
</nav>
<?php
$cookie->hint();
?>
<div class="header">
	
	<?php 
		show_header();
	?>

<?php
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
		if (FW_MODUL_MATERIAL_BUTTON == true){
			echo "<a href='".@FW_MODUL_MATERIAL_BUTTON_LINK."' class=\"material_button\"><img style=\"height:90%;padding-top:5%;auto;\" alt=\"info\" src=\"images/icons/material_button.png\"></a>";
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

echo modul_show_script(0);
?>

<script type="text/javascript" src="inc/library/js.inc.js"></script>


<?php show_note();

$ENDTIME = microtime(true);
$RUNTIME = $ENDTIME - $STARTTIME;
$RUNTIME = round ($RUNTIME, 3);
$RUNTIME_MS = $RUNTIME * 1000;
$USERAGENT = $_SERVER['HTTP_USER_AGENT'];
$SCRIPT_NAME = basename($_SERVER['SCRIPT_NAME']);
$SCRIPT_PARENT = dirname($_SERVER['SCRIPT_NAME']);

if(isset ($_GET['p'])){
	$SCRIPT_NAME = $SCRIPT_NAME."?".$_GET['p'];
}
//
statistics_collector($SCRIPT_NAME, $USERAGENT, $RUNTIME_MS, $SCRIPT_PARENT);
//
$query_count = $db_my->query_count;
$query_time = $db_my->query_time;
$query_strings= $db_my->query_strings;
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