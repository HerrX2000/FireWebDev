<?php
#removed because session starts to
define('FW_C', true);
require("global.php");
if (!isset($_GET['a'])){
	$FW_C_ACTION = $settings['index_act'];
	$_GET['a']=$settings['index_act'];
	$_GET['p']=$settings['index_page'];
}
else{
	$FW_C_ACTION = $_GET['a'];
}
define('FW_C_CORE', $settings['core']);
define('FW_C_ACTION', $FW_C_ACTION);
require_once(FW_ROOT."/inc/controller/c_base.php");
if(include(FW_ROOT."/inc/controller/c_".$settings['controller'].".php")){
}
else{
	require(FW_ROOT."/inc/controller/c_dynamic.php");
}
$c = new controller();
if(include(FW_SERVER_ROOT."/core/".FW_C_CORE.".php")){
	return true;
	}
else{
	echo"<h1>Selected core doesn't exist</h1>";
	require(FW_SERVER_ROOT."/core/core.php");
}
?>