<?php 
function fw_detect_tables($mode="default",$clear_prefix=false){
	if ($mode=="default"){
		global $db_my;
		$return = array();
		$query="SHOW TABLES";

		//
		$result=$db_my->query($query, $hide_errors=0, $write_query=0);			
		//
		
		$prelen = strlen($db_my->prefix);	
		while ($row = $db_my->fetch_array($result, MYSQLI_NUM)){
			$rows[] = $row ;
		}
		foreach($rows as $row){
			if (strpos($row[0],"removed_")=== $prelen){
				$res=array("removed",$row[0]);
							}
			elseif (strpos($row[0],"area_")=== $prelen){
				$res=array("area",$row[0]);
							}
			elseif (strpos($row[0],"at_")=== $prelen){
				$res=array("addon",$row[0]);
							}
			elseif (strpos($row[0],"entries_")=== $prelen){
				$res=array("entries",$row[0]);
							}
			elseif(strpos($row[0],"fw_")=== $prelen){
				$res=array("fireweb",$row[0]);
							}
			elseif(strpos($row[0],"pages")=== $prelen){
				$res=array("pages",$row[0]);
							}
			elseif(strpos($row[0],"settings")=== $prelen){
				$res=array("settings",$row[0]);
							}
			elseif(strpos($row[0],"users")=== $prelen){
				$res=array("users",$row[0]);
							}
			else{
				$res=array(false,$row[0]);
				}
			array_push($return,$res);
		}
	return $return;
	}	
	elseif ($mode!="default"){
		global $db_my;
		$return = array();
		$query="SHOW TABLES";

		//
		$result=$db_my->query($query, $hide_errors=0, $write_query=0);			
		//
		
				$prelen = strlen($db_my->prefix);	
		while ($row = $db_my->fetch_array($result, MYSQLI_NUM)){
			$rows[] = $row ;
		}
		foreach($rows as $row){

		if (strpos($row[0],$mode)=== $prelen){	
				if($clear_prefix==true){
					$row[0] = str_replace($db_my->prefix,"",$row[0]);
				}
				$row_c = str_replace($mode."_","",$row[0]);
				$res=array($mode,$row[0],$row_c);
				array_push($return,$res);
		}
		else{
			false;
			}
		}
	return $return;
	}
}
function fw_detect_tables_render($in,$style=null){
	global $c;
	echo"<table style=".$style."><tr>";
	foreach($in as $entry){
		echo "<tr><td>".$entry[0]."</td>";
		switch ($entry[0]){
			case "pages":
				echo"<td><a href=".$c->ref("administration","edit_page").">Bearbeiten</a></td>";
				break;
			default:
				echo"<td></td>";
		}
		echo "<td>".$entry[1]."</td></tr>";
	}
	echo"</table>";
}

?>