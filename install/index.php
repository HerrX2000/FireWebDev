<?php
$STARTZEIT = microtime(true);
?>
<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
 
if(isset($_GET['lang']))
{
$lang = $_GET['lang'];
 
// register the session and set the cookie
$_SESSION['lang'] = $lang;
 
setcookie('lang', $lang, time() + (3600 * 24 * 30));
}
else if(isset($_SESSION['lang']))
{
$lang = $_SESSION['lang'];
}
else if(isset($_COOKIE['lang']))
{
$lang = $_COOKIE['lang'];
}
else
{
$lang = 'en';
}

include("strings-".$lang.".php");
include("include.php");
include("config.php");
?>
<?php
		//cookie();
?>
<!doctype html>
<head>
<meta charset="utf-8">
<meta name="robots" content="NOINDEX, NOFOLLOW">
<link rel="stylesheet" type="text/css" href="../style/basis/style.css">
<link rel="stylesheet" type="text/css" href="./style.css">
<title><?php echo $string['PAGE_TITLE'];?></title>
</head>
<body>

<header id="header">
<h1><?php echo $config['title']." ".$string['INSTALLATION'];?></h1>
</header>
<div id="middle">
<div id="container">


<div id="container_center">
<section class="section">
<?php if (!isset($_GET['page']) or $_GET['page']==1)initialize();elseif($_GET['page']==2)check_con();elseif($_GET['page']==3)installation();?>
</section>
</div>
</div>
</div>
<footer id="footer">
<?php echo $string['PAGE_FOOTER'];?>
</footer>

<?php
$ENDZEIT = microtime(true);
$LAUFZEIT = $ENDZEIT - $STARTZEIT;
$LAUFZEIT = round ($LAUFZEIT, 3);
echo"
<!--
Seitenaufbaudauer: $LAUFZEIT Sekunden
-->"; 
?>
<!--<h3>	English </h3>
<p>Moco (More Control) is a organizer software under development and part of the "FireWeb" webbased software series.</p>

<p>Copyright (C) 2014-2015 Frederik Mann</p>

<p>This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 3 of the License, or (at your option) any later version.</p>

<p>This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.</p>

<p>You should have received a copy of the GNU General Public License along with this program; if not, see <http://www.gnu.org/licenses/>.</p>
		
<p>The source code is currently not available to download. To get the sourcecode contact me.</p>

<p>Thanks to the Notepad++ Team!
<br>
	
<h3>	German </h3>
<p>Moco (More Control) ist eine Terminkalender Software in Entwicklung und Teil der "FireWeb" webbasierten Softwareserie.
<br>Copyright (C) 2014-2015 Frederik Mann</p>

<p>Dieses Programm ist freie Software. Sie können es unter den Bedingungen der GNU General Public License,
wie von der Free Software Foundation veröffentlicht, weitergeben und/oder modifizieren,
entweder gemäß Version 3 der Lizenz oder (nach Ihrer Option) jeder späteren Version.</p>

<p>Die Veröffentlichung dieses Programms erfolgt in der Hoffnung, daß es Ihnen von Nutzen sein wird,
aber OHNE IRGENDEINE GARANTIE, sogar ohne die implizite Garantie der MARKTREIFE oder
der VERWENDBARKEIT FüR EINEN BESTIMMTEN ZWECK. Details finden Sie in der GNU General Public License.</p>

<p>Sie sollten ein Exemplar der GNU General Public License zusammen mit diesem Programm erhalten haben. Falls nicht, siehe <http://www.gnu.org/licenses/>.</p>

<p>Der Quellcode ist zur Zeit nicht verfügbar zum Download. Um den Quellcode zu bekommen kontaktiere mich.</p>

<p>Thanks to the Notepad++ Team!</p>-->