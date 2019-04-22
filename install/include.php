<?php

if(isSet($_SESSION['lang']))
{
$lang = $_SESSION['lang'];
include("strings-".$lang.".php");
}
else if(isSet($_COOKIE['lang']))
{
$lang = $_COOKIE['lang'];
include("strings-".$lang.".php");
}
else{
include("strings-en.php");
}

error_reporting(E_ALL);
ini_set('display_errors', '1');

if (file_exists('BOLT'))
{
	echo $string['BOLT'];
	exit;
}

function initialize(){
global $string;

if (version_compare(PHP_VERSION, '5.6', '<'))
{
	echo $string['OLD_PHP_VERSION'];
}

if (version_compare(PHP_VERSION, '5.3.10', '<'))
{
	echo $string['OLD_PHP_VERSION'];
	echo"<script type=\"text/javascript\">alert('".$string['OLD_PHP_VERSION']."') </script>";
}

echo"<form action=\"index.php?page=check_connection\" method=\"post\" >
	<fieldset>
	<legend><h2>".$string['INSTALL_TITLE']."</h2></legend>
	<table>
	
	<tr><td>".$string['INSTALL_SERVERNAME'].":</td> <td><input name=\"host\" type=\"text\" required></td></tr>
	
	<tr><td></td> <td>".$string['INSTALL_SERVERNAME_HINT']."<br><br></td></tr>
	
	<tr><td>".$string['INSTALL_USERNAME'].":</td> <td><input name=\"username\" type=\"text\" required></td></tr>
	
	<tr><td></td> <td>".$string['INSTALL_USERNAME_HINT']."<br><br></td></tr>
	
	<tr><td>".$string['INSTALL_PASSWORD'].":</td> <td><input name=\"password\" type=\"password\"></td></tr>
	
	<tr><td></td> <td>".$string['INSTALL_PASSWORD_HINT']."<br><br></td></tr>
	
	<tr><td>".$string['INSTALL_DATABASENAME'].":</td> <td><input name=\"db\" type=\"text\" required></td></tr>
	<tr><td></td> <td><br><br></td></tr>
	<tr><td>".$string['INSTALL_PREFIX'].":</td> <td><input name=\"prefix\" placeholder=\"RND_\" type=\"text\"></td></tr>
	
	<tr><td></td> <td>".$string['INSTALL_PREFIX_HINT']."<br><br></td></tr>
	
	<tr><td></td><td><input type=\"submit\" value=\"".$string['SUBMIT']."\"></fieldset></td></tr>
	</table>
	</form>
	<p align=\"right\">
	<a href=\"?lang=en\"><img src=\"lang_en.png\" alt=\"lang_en\"></a>
	<a href=\"?lang=de\"><img src=\"lang_de.png\" alt=\"lang_de\"></a></p>
	";
echo$string['INSTALL_WARNING'];
}

function check_con(){
	global $string;
	$db_host=$_POST['host'];
	$db_user=$_POST['username'];
	$db_psw=$_POST['password'];
	$db_name=$_POST['db'];
	$db_prefix=$_POST['prefix'];

	// Create connection
	$db_con = new mysqli($db_host, $db_user, $db_psw, $db_name);

	// Check connection
	if ($db_con->connect_error) {
		echo"<form action=\"index.php?page=check_connection\" method=\"post\" >
		<fieldset>
		<legend><h2>Connection failed: ". $db_con->connect_error."</h2></legend>
		<table>
		
		<tr><td>".$string['INSTALL_SERVERNAME'].":</td> <td><input name=\"host\" value=\"$db_host\" type=\"text\" required></td></tr>
		
		<tr><td></td> <td>".$string['INSTALL_SERVERNAME_HINT']."<br><br></td></tr>
		
		<tr><td>".$string['INSTALL_USERNAME'].":</td> <td><input name=\"username\" value=\"$db_user\" type=\"text\" required></td></tr>
		
		<tr><td></td> <td>".$string['INSTALL_USERNAME_HINT']."<br><br></td></tr>
		
		<tr><td>".$string['INSTALL_PASSWORD'].":</td> <td><input name=\"password\" value=\"$db_psw\" type=\"password\"></td></tr>
		
		<tr><td></td> <td>".$string['INSTALL_PASSWORD_HINT']."<br><br></td></tr>
		
		<tr><td>".$string['INSTALL_DATABASENAME'].":</td> <td><input name=\"db\" value=\"$db_name\" type=\"text\" required></td></tr>
		<tr><td></td> <td><br><br></td></tr>
		<tr><td>".$string['INSTALL_PREFIX'].":</td> <td><input name=\"prefix\" value=\"$db_prefix\" type=\"text\"></td></tr>
		
		<tr><td></td> <td>".$string['INSTALL_PREFIX_HINT']."<br><br></td></tr>
		
		<tr><td></td><td><input type=\"submit\" value=\"Submit\"></fieldset></td></tr>
		</table>
		</form>
		<p align=\"right\">
		<a href=\"?lang=en\"><img src=\"../images/lang_en.gif\" alt=\"lang_en\"></a>
		<a href=\"?lang=de\"><img src=\"../images/lang_de.gif\" alt=\"lang_de\"></a></p>";
	}
	else echo "<fieldset style=\"min-height:220px;\">
		<legend><h2>Connected successfully</h2></legend>
		<form action=\"index.php?page=installing\" method=\"post\" >
		<input type=\"hidden\" name=\"host\" value=\"$db_host\">
		<input type=\"hidden\" name=\"username\" value=\"$db_user\">
		<input type=\"hidden\" name=\"password\" value=\"$db_psw\">
		<input type=\"hidden\" name=\"db\" value=\"$db_name\">
		<input type=\"hidden\" name=\"prefix\" value=\"$db_prefix\">
		<input type=\"hidden\" name=\"mode\" value=\"simple\">
		<div style=\"text-align:center;margin-bottom:14px;\"><h3>".$string['INSTALL_SIMPLE_TITLE']."</h3>
		<input type=\"submit\" value=\"1-Click-Installation\">
		<p>".$string['INSTALL_SIMPLE_HINT']."</p>
		</form>
		</div>
		<form action=\"index.php?page=advanced_setup\" method=\"post\" >
		<input type=\"hidden\" name=\"mode\" value=\"advanced\">
		<fieldset>
		<legend>".$string['INSTALL_ADVANCED_TITLE']."</legend>
		<input type=\"hidden\" name=\"host\" value=\"$db_host\">
		<input type=\"hidden\" name=\"username\" value=\"$db_user\">
		<input type=\"hidden\" name=\"password\" value=\"$db_psw\">
		<input type=\"hidden\" name=\"db\" value=\"$db_name\">
		<input type=\"hidden\" name=\"prefix\" value=\"$db_prefix\">
		<input type=\"hidden\" name=\"mode\" value=\"advanced\">
		<input type=\"submit\" value=\"".$string['INSTALL_ADVANCED_SEND']."\">
		</fieldset>
		</form>
		<form action=\"#\" method=\"post\" >
		<input type=\"hidden\" name=\"mode\" value=\"advanced\">
		<fieldset>
		<legend>".$string['REPAIR_TITLE']."</legend>
		<input type=\"submit\" value=\"".$string['REPAIR_SEND']."\">
		</fieldset>
		</form>
		</fieldset>";

	echo"
	</fieldset>
	";
}

function advanced_setup(){
	global $string;
	$db_host=$_POST['host'];
	$db_user=$_POST['username'];
	$db_psw=$_POST['password'];
	$db_name=$_POST['db'];
	$db_prefix=$_POST['prefix'];
	echo "<form action=\"index.php?page=installing\" method=\"post\" >
	<fieldset>
	<legend><h2>".$string['INSTALL_ADVANCED_SETTINGS']."</h2></legend>
	<table>
	<tr><td>".$string['INSTALL_SETTINGS']."</td> <td></td></tr>
	<input type=\"text\" name=\"mode\" value=\"advanced\" readonly>
	<tr><td>".$string['INSTALL_SERVERNAME'].":</td> <td><input name=\"host\" type=\"text\" value=\"{$_POST['host']}\" readonly></td></tr>
	<tr><td>".$string['INSTALL_USERNAME'].":</td> <td><input name=\"username\" type=\"text\" value=\"{$_POST['username']}\" readonly></td></tr>
	<tr><td>".$string['INSTALL_PASSWORD'].":</td> <td><input name=\"password\" type=\"password\" value=\"{$_POST['password']}\" readonly></td></tr>	
	<tr><td>".$string['INSTALL_DATABASENAME'].":</td> <td><input name=\"db\" type=\"text\" value=\"{$_POST['db']}\" readonly></td></tr>
	<tr><td>".$string['INSTALL_PREFIX'].":</td> <td><input name=\"prefix\" value=\"{$_POST['prefix']}\" readonly type=\"text\"></td></tr>
	<tr><td>".$string['INSTALL_ADVANCED_SETTINGS']."</td> <td></td></tr>
	<tr><td>".$string['INSTALL_PAGE_NAME'].":</td> <td><input name=\"page_name\" type=\"text\" required></td></tr>
	<tr><td></td><td><input type=\"submit\" value=\"".$string['SUBMIT']."\"></fieldset></td></tr>
	</table>
	</form>";
}
/*<h3>	English </h3>
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

<p>Thanks to the Notepad++ Team!</p>*/
?>
