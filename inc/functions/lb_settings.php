<?php
function show_settings_entries($target){
		//////////////////////
		//					//
		//	List Settings	//
		//					//
		//////////////////////
		global $db_my;
		// 
		//$db_my->query("SET NAMES 'utf8'", $hide_errors=0, $write_query=0);
		//
		$query="SELECT id,name,title,value from ". $db_my->prefix ."settings ORDER BY id ASC";

		//
		$result=$db_my->query($query, $hide_errors=0, $write_query=0);			
		//
		
		echo "<table id='settings' style='width:100%;border-style:solid;border-color:#D3D3D3;border-collapse: collapse;border-width: 1px;'>";
			
		while ($row = $db_my->fetch_assoc($result)){
			$rows[] = $row ;
		}
		foreach($rows as $row){
			echo "<tr>";
			echo "<td style='border-style:solid;border-color:#585858;border-width: 1px;'><span id='tooltip'><a href='#' class='link'><b>".$row['title']."</b><span>".$row['name']."</span></span></td>";
			echo "<td style='border-style:solid;border-color:#585858;border-width: 1px;height:54px;'>".$row['value']."</td>";
			echo "<td style='border-style:solid;border-color:#585858;border-width: 1px;width:33px;'>
			<form name='aendern_start' action='?p=$target&id=".$row["id"]."' method='post'>
			<input type='hidden' name='id' value='".$row['id']."'>
			<input type='hidden' name='name' value='".$row["name"]."'>
			<input type='hidden' name='title' value='".$row["title"]."'>
			<input type='hidden' name='value' value='".$row["value"]."'>
			<input type='image' src='images/icons/edit.png' style='wdith:32px;height:32px;' alt='edit_event'>			
			</form>
			</td>";
			echo "</tr>";			
		}			
		echo"</table>";
}
function edit_settings_entry($id,$value){
			global $db_my;
			//
			$id = $db_my->escape_string($id); 
			$value = $db_my->escape_string($value);
			//
			if($db_my->query("UPDATE ". $db_my->prefix ."settings SET value='$value' WHERE id='$id' or name='$id'")){
				return true;
				//allways returns true 
			}
}
?>