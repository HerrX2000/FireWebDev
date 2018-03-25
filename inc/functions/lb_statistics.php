<?php 
function statistics_collector($page = "", $useragent = "", $time="", $parent = "/"){
		if ($time != ""){
			if ($time > 9999){
				$time = 9999;
			}
		global $db_my;
		global $settings; 
		$page_version = @FW_VERSION ." ". @FW_VERSION_STATUS;
		$page_api = @FW_API;
		$useragent = $db_my->escape_string($useragent);
		$core = $settings['core'];
		$module = $settings['module'];
		if (isset ($_COOKIE["sessionid"])){
			$sessionid = date ('d').$_COOKIE["sessionid"];
			$query="INSERT INTO fw_statistic (`id`, `date_time`, `pagename`, `pageparent`, `pageversion`, `pageapi`, `core`, `module`, `useragent`, `sessionid`, `exe_time`) VALUES (0,NULL,'".$page."','".$parent."','".$page_version."','".$page_api."','".$core."','".$module."','".$useragent."','".$sessionid."','".$time."')";
		}
		else{
			$query="INSERT INTO fw_statistic (`id`, `date_time`, `pagename`, `pageparent`, `pageversion`, `pageapi`, `core`, `module`, `useragent`, `exe_time`) VALUES (0,NULL,'".$page."','".$parent."','".$page_version."','".$page_api."','".$core."','".$module."','".$useragent."','".$time."')";
		}
		$db_my->query($query, $hide_errors=0, $write_query=0);
		}
}
?>