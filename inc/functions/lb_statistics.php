<?php 
function statistics_collector($action = "", $useragent = "", $time="", $page = ""){
	if ($time != ""){
		if ($time > 9999){
			$time = 9999;
		}
		global $db_my;
		global $settings; 
		$action = $db_my->escape_string($action);
		$page = $db_my->escape_string($page);
		$page_version = @FW_VERSION ." ". @FW_VERSION_STATUS;
		$page_api = @FW_API;
		$useragent = $db_my->escape_string($useragent);
		$core = $settings['core'];
		$module = $settings['module'];
		if (isset ($_COOKIE["sessionid"])){
			$sessionid = date ('dm').$_COOKIE["sessionid"];
			}
		else{
			$sessionid = null;
		}
		$query="INSERT INTO fw_statistic (`id`, `date_time`, `action`, `page`, `version`, `api`, `core`, `module`, `useragent`, `sessionid`, `exe_time`) VALUES (0,NULL,'".$action."','".$page."','".$page_version."','".$page_api."','".$core."','".$module."','".$useragent."','".$sessionid."','".$time."')";
		
		$db_my->query($query, $hide_errors=0, $write_query=1);
	}
}

?>