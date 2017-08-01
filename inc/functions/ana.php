<?php 
global $db_link_i_obj;
		if (@FW_PAGE_VERSION === null or @FW_PAGE_VERSION == "FW_PAGE_VERSION "){$page_version = null;}
		else {$page_version = @FW_PAGE_VERSION;}
		if (@FW_PAGE_API === null){$page_api = 6;}
		else {$page_api = @FW_PAGE_API;}
		$useragent = $db_link_i_obj->real_escape_string($useragent);
		$insert="INSERT INTO statistic (`id`, `date_time`, `pagename`, `pageparent`, `pageversion`, `pageapi`, `useragent`, `time`) VALUES (0,NULL,'".$page."','".$parent."','".$page_version."','".$page_api."','".$useragent."','".$time."')";
		$db_link_i_obj->query($insert);
?>