<?php
/*
require_once '../inc/config.php';
require_once '../inc/db_base.php';
require_once '../inc/db_mysqli.php';
$db_my = new DB;
$db_my->connect($config);
$db_my->initiate();

//grap settings
$query="SHOW TABLES";
//
$result=$db_my->query($query, $hide_errors=0, $write_query=0);
$tables=array();
while ($row = $result->fetch_row()) {
	if (strpos($row[0], 'entry') !== false) {
		echo 'Found|'.$row[0];
		array_push($tables, $row[0]);
	}
}

foreach ($tables as $table){
	$table_prefix = str_replace("entry", "", $table);
	echo " ".$table." ";
	$update = $db_my->query("RENAME TABLE `" . $table . "` TO `" . $table_prefix. "pages`" );
}
if ($result){
	echo "connected";
}
if ($update){
	echo "geupdated";
}
			
$query="SHOW TABLES";
//
$result=$db_my->query($query, $hide_errors=0, $write_query=0);
$tables=array();
while ($row = $result->fetch_row()) {
	if (strpos($row[0], 'pages') !== false) {
		echo '<br>Allready updated: '.$row[0];
		array_push($tables, $row[0]);
	}
}
			
*/
?>