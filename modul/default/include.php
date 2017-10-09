<?php
/**
 * FireWeb webbased software series
 * Copyright 2014-2016 Frederik Mann, All Rights Reserved
 *
 * License: http://www.gnu.org/licenses/
 *
 */
 
define("FW_MODUL_VERSION", "0.7a");
define("FW_MODUL_API", "7");
define("FW_MODUL_MATERIAL_BUTTON", false);

///Init Include required library start
include_once(FW_ROOT."/inc/functions/find_mobile_browser.php");
require_once(FW_ROOT."/inc/functions/fw_users.php");
require_once(FW_ROOT."/modul/default/main.php");
///Init Include required library end

///Init Include current selected file start
$filename=$_SERVER['SCRIPT_NAME'];  
$path = pathinfo($filename);
$filename = $path["filename"].".".$path["extension"];
if(file_exists(FW_ROOT."/modul/default/".$path["filename"].".inc.php")){
	include(FW_ROOT."/modul/default/".$path["filename"].".inc.php");
}
else{
	include(FW_ROOT."/modul/core/".$filename.".inc.php");
	echo FW_ROOT."/modul/core/".$filename.".inc.php";
	echo "success";
}
///Init Include current selected file end
?>