<?php


/*
Script by SpYk3HH
On Stackoverflow http://stackoverflow.com/questions/2820723/how-to-get-base-url-with-php
*/
if (!function_exists('base_url')) {
    function base_url($atRoot=FALSE, $atCore=FALSE, $parse=FALSE){
        if (isset($_SERVER['HTTP_HOST'])) {
            $http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
            $hostname = $_SERVER['HTTP_HOST'];
            $dir =  str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);

            $core = preg_split('@/@', str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__))), NULL, PREG_SPLIT_NO_EMPTY);
            $core = $core[0];

            $tmplt = $atRoot ? ($atCore ? "%s://%s/%s/" : "%s://%s/") : ($atCore ? "%s://%s/%s/" : "%s://%s%s");
            $end = $atRoot ? ($atCore ? $core : $hostname) : ($atCore ? $core : $dir);
            $base_url = sprintf( $tmplt, $http, $hostname, $end );
        }
        else $base_url = 'http://localhost/';

        if ($parse) {
            $base_url = parse_url($base_url);
            if (isset($base_url['path'])) if ($base_url['path'] == '/') $base_url['path'] = '';
        }

        return $base_url;
    }
}


/*
Script end
*/
//PHP_Bibilothek

/*
default settings (overwriteable)
*/
$settings['version'] = "0.7.2";
$settings['api'] = "7";
$settings['module'] = "default";
$settings['lang'] = "en";
define("FW_VERSION", $settings['version']);
define("FW_VERSION_STATUS", "");
define("FW_API", $settings['api']);
define('FW_ROOT', dirname(__FILE__));
define('FW_SERVER_ROOT', dirname(__FILE__));
define('FW_CLIENT_ROOT', base_url());
if (isset($_SESSION["username"])){
	define('FW_USER_NAME', $_SESSION["username"]);
	define('FW_USER_ID', $_SESSION["uid"]);
}

require_once 'inc/config.php';
require_once 'inc/db_base.php';
require_once 'inc/db_mysqli.php';
$db_my = new DB;
$db_my->connect($config);
$db_my->initiate();
$db_my->prefix;
//outdate but in calendar

$db_link_i = new DB;

//grap settings
$query="SELECT id,name,value from ". $db_my->prefix ."settings ORDER by ID ";
//
$result=$db_my->query($query, $hide_errors=0, $write_query=0);
//
while ($row = $db_my->fetch_assoc($result))
{
$rows[] = $row ;
}
foreach($rows as $row){
			$name = $row['name'];
			$settings[$name]=$row['value'];
			}
define('FW_LANG', $settings['lang']);
define('FW_MODULE', $settings['module']);
$name = null;
$result = null;
$query = null;
$rows = null;
$row = null;
//recaptcha settings
$settings ['recaptcha'] = 0;
$settings ['recaptcha_key'] = "6LfriyETAAAAADZQ65lKV9zcinpwPsdUWhcicdvp";

?>