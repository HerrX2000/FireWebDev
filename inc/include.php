<?php
/**
 * FireWeb webbased software series
 * Copyright 2014-2016 Frederik Mann, All Rights Reserved
 *
 * License: http://www.gnu.org/licenses/
 *
 */

//require_once(FW_ROOT."/modul/include.php");

 
require_once(FW_ROOT."/inc/functions/php.inc.php");
require_once(FW_ROOT."/inc/functions/fw_users.inc.php");
include_once(FW_ROOT."/inc/functions/find_mobile_browser.php");

//Function Modul_include		
function modul_include($modul=null){
	if(!isset($modul)){
		global $settings;
		$modul=$settings['modul'];
		}
	if(!include_once FW_ROOT."/modul/$modul/include.php"){
		include_once FW_ROOT."/modul/core/include.php";
	}
}
?>
