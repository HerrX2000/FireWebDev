<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

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

global $string;

//////////////
/*
 * Updated for Version 0.7beta 31.7.17			
 *
 * FireWeb webbased software series
 * Copyright 2017 Frederik Mann, All Rights Reserved
 *
 * License: http://www.gnu.org/licenses/
 *
 */
//////////////


$config['title']="FireWeb";


function installation(){
$db_host = $_POST['host'];
$db_user = $_POST['username'];
$db_psw = $_POST['password'];
$db_name = $_POST['db'];
$db_prefix = $_POST['prefix'];

if($db_host == "" or $db_user == "" or $db_name == ""){
	echo "Host User or DBName not set";
	die;
};

$mode = $_POST['mode'];
if ($db_prefix=="")
{
	$db_prefix=NULL;
}
$file = fopen("../inc/config.php", "w") or die("Unable to creat inc/config.php!");
$txt = "<?php
//Enable Multi-Databases (not recommended)
\$config['db']['multiple'] = false;
\$config['db']['separate'] = false; //separate in read and write? not supported yet

//configuration of database
\$config['db']['type'] = 'mysqli';
\$config['db']['db'] = \"$db_name\";
\$config['db']['prefix'] = \"$db_prefix\";

\$config['db']['hostname'] = \"$db_host\";
\$config['db']['username'] = \"$db_user\";
\$config['db']['password'] = \"$db_psw\";

\$config['db']['encoding'] = 'utf8';
?>
";

fwrite($file, $txt);
echo "Created config.php successfully<br>";
fclose($file);
if ($mode=="simple"){
	$db_con = new mysqli($db_host, $db_user, $db_psw, $db_name);
	$sql = "CREATE TABLE `".$db_prefix."settings` (
		  `id` smallint(5) NOT NULL AUTO_INCREMENT,
		  `name` varchar(120) NOT NULL UNIQUE,
		  `title` varchar(120) NOT NULL,
		  `description` text,
		  `optionscode` text,
		  `value` text NOT NULL,
		  PRIMARY KEY (ID)
		) DEFAULT CHARSET=utf8;
		";
		//uniqu @ name not tested
	
if ($db_con->query($sql) === TRUE) {
    echo "Table Settings created successfully<br>";
	$existed = 0;
} else {
	$existed = 1;
    echo "Error  creating table Settings: ".$db_con->error ."<br>";
}
if ($existed ==0){
	$sql = "INSERT INTO `".$db_prefix."settings` (`id`,`name`, `title`, `value`) VALUES
	(1, 'status', 'Online/Offline', '1'),
	(2, 'status_reason', 'Status Reason', ''),
	(3, 'home_name', 'Root Website Name', 'Homepage'),
	(4, 'home_url', 'Root URL', '/'),
	(5, 'page_name', 'Homepage Name', 'Homepage'),
	(6, 'page_url', 'Homepage URL', '/'),
	(7, 'adminemail', 'Admin Email', ''),
	(8, 'cookiedomain', 'Cookie Domain', ''),
	(9, 'cookiepath', 'Cookie Path', '/'),
	(10, 'cookieprefix', 'Cookie Prefix', ''),
	(11, 'meta_description', 'Meta Description', ''),
	(12, 'meta_keywords', 'Meta Keywords', ''),
	(13, 'meta_robots', 'Meta Robots', ''),
	(14, 'default_style', 'Default Style', 'default'),
	(15, 'version', 'FireWeb Version', '0.8alpha'),
	(16, 'module', 'Selected Module', 'default'),
	(17, 'core', 'Selected Core', 'core'),
	(18, 'menu_order', 'Menu Order', 'Start=page=fw_quickstart'),
	(19, 'lang', 'Language', 'en'),
	(20, 'recaptcha_key', 'Recaptcha Key', ''),
	(22, 'index_fun', 'Start Page Function', 'page'),
	(23, 'index_act', 'Start action', 'page'),
	(24, 'index_page', 'Start page', 'index'),
	(25, 'controller', 'controller', 'dynamic');
	";

	//////////////////////
		
	if ($db_con->query($sql) === TRUE) {
		echo "Insert into ".$db_prefix."settings successfully<br>";
	} else {
		$error = true;
		echo "Error  insert into ".$db_prefix."Settings: ".$db_con->error ."<br>";
	}
}

/////create pages

$db_con = new mysqli($db_host, $db_user, $db_psw, $db_name);
	$sql = "
	CREATE TABLE `".$db_prefix."pages` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `name` varchar(120) NOT NULL,
		  `title` varchar(120) NOT NULL,
		  `content` text NOT NULL,
		  `modifiable` int(1) NOT NULL DEFAULT '1',
		   PRIMARY KEY (ID)
		) CHARSET=utf8;
		";
		
	
if ($db_con->query($sql) === TRUE) {
    echo "Table pages created successfully<br>";
	$existed = 0;
} else {
	$existed = 1;
	echo "Error  creating table pages: ".$db_con->error ."<br>";
}

if ($existed ==0){
	$sql = "INSERT INTO `".$db_prefix."pages`
	(`id`, `name`, `title`, `content`, `modifiable`)
	VALUES
	(NULL, 'fw_quickstart', 'Quickstart', '<div class=\'content\'>
	<h1>FireWeb installed</h1> <p>You can now login and start customizing your website.</p>
	<p>We have created an admin account.</p>
	<p>Name: admin<br />Password: admin</p>
	</div>', '1');
	";

	//////////////////////
		
	if ($db_con->query($sql) === TRUE) {
		echo "Insert into ".$db_prefix."users successfully<br>";
	} else {
		$error = true;
		echo "Error  insert into ".$db_prefix."users: ".$db_con->error ."<br>";
	}
}


/////create stats
$db_con = new mysqli($db_host, $db_user, $db_psw, $db_name);
	$sql = "
		CREATE TABLE IF NOT EXISTS `fw_statistic` (
		  `id` int(11) UNSIGNED NOT NULL  AUTO_INCREMENT,
		  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  `action` varchar(240) NOT NULL,
		  `page` varchar(480) NOT NULL DEFAULT '/',
		  `version` tinytext,
		  `api` smallint(5) DEFAULT NULL,
		  `core` tinytext,
		  `module` tinytext,
		  `useragent` text NOT NULL,
		  `sessionid` mediumint(7),
		  `exe_time` smallint(5) NOT NULL,
		   PRIMARY KEY (ID)
		) CHARSET=utf8;
		";
		
	
if ($db_con->query($sql) === TRUE) {
    echo "Table fw_statistic created successfully<br>";
} else {
    $error = true;
	echo "Error  creating table statistic: ".$db_con->error ."<br>";
}
$sql = "
		CREATE TABLE `fw_statistic_archive` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `date_time_start` datetime NOT NULL,
		  `date_time_end` datetime NOT NULL,
		  `total` int(11) NOT NULL,
		  `total_pc` int(11) NOT NULL,
		  `total_mobile` int(11) NOT NULL,
		  `avg_time` float NOT NULL,
		  `avg_time_pc` float NOT NULL,
		  `avg_time_mobile` float NOT NULL,
		  `avg_api` smallint(6) NOT NULL,
		   PRIMARY KEY (ID)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";
if ($db_con->query($sql) === TRUE) {
    echo "Table fw_statistic_archive created successfully<br>";
} else {
    $error = true;
	echo "Error  creating table statistic_archive: ".$db_con->error ."<br>";
}
/////create user admin
$db_con = new mysqli($db_host, $db_user, $db_psw, $db_name);
	$sql = "
		CREATE TABLE `".$db_prefix."users` (
		  `id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT,
		  `username` varchar(100) NOT NULL,
		  `password` varchar(100) NOT NULL,
		  `algo` varchar(20) NOT NULL DEFAULT 'bcyrpt',
		  `salt` varchar(8) DEFAULT NULL,
		  `loginkey` varchar(100) NOT NULL,
		  `email` varchar(300) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
		  `usergroup` int(1) NOT NULL DEFAULT '0',
		  `moderator` int(1) NOT NULL DEFAULT '0',
		  `admin` int(1) NOT NULL DEFAULT '0',
		  PRIMARY KEY (ID)
		) CHARSET=utf8;
		";
		
	
if ($db_con->query($sql) === TRUE) {
    echo "Table users created successfully<br>";
	$existed = 0;
} else {
	$existed = 1;
	echo "Error  creating table users: ".$db_con->error ."<br>";
}
if ($existed ==0){
	$sql = "INSERT INTO `".$db_prefix."users`
	(`id`, `username`, `password`, `algo`, `salt`, `loginkey`, `email`, `usergroup`, `moderator`, `admin`)
	VALUES
	(NULL, 'admin', 'admin', 'none', NULL, '', '', '0', '0', '1');
	";

	//////////////////////
		
	if ($db_con->query($sql) === TRUE) {
		echo "Insert into ".$db_prefix."users successfully<br>";
	} else {
		$error = true;
		echo "Error  insert into ".$db_prefix."users: ".$db_con->error ."<br>";
	}
}

////
////

$db_con->close();
	}
if(!$error){
	echo "
	<h2>SUCCESSFUL</h2>
	<p>{$string[INSTALL_FINISHED_HINT]}</p>
	<h3><a href=\"../index.php\">CONNTINUE</a></h3>
	<script type=\"text/javascript\">
	  setTimeout(function () { location.href = \"../index.php\"; }, 5000);
	</script>
	";
	$file = fopen("./BOLT", "w") or die("Unable to creat global.php!");
fclose($file);
}
{
	echo "
	<h2>FAILURE</h2>";
}
}

?>