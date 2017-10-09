<?php 
//page
function show_page($table='', $id=''){
	return entry($table, $id);
}
function show_page_edit_button($table='', $p){
	global $db_my;
	if (ctype_digit($p)==true){
		$query="SELECT id,name from ". $db_my->prefix ."$table WHERE id = '$p'";
	}
	else{
		$query="SELECT id,name from ". $db_my->prefix ."$table WHERE name = '$p'";
	}
	//
	$result=$db_my->query($query, $hide_errors=1, $write_query=0);
	//
	while ($row =  $db_my->fetch_assoc($query=$result))
	{
	$rows[] = $row ;
	}
	foreach($rows as $row){
		$id=$row['id'];
		$name=$row['name'];
	}
	echo"
	<div class='content' style='float:right;'>
	<form action='page.php?a=edit&p=".$name."&id=".$id."' method='post'>
	<input type='hidden' name='table' value='".$table."'>
	<input type='hidden' name='id' value='".$id."'>
	<input type='hidden' name='name' value='".$name."'>
	<input type='image' src='images/icons/entry_edit.png' style='wdith:32px;height:32px;' alt='edit_entry'>
	</form>
	</div>
	";
}
function page_title($default='')
{
	if (isset ($_GET["p"]))
	{
	$title = $_GET["p"];
	$title = ucwords($title);
	}
	elseif (isset ($default))
	{
	$titel = $default;
	}
	return $title;
}	
function show_pages_list($target){
		//////////////////////
		//					//
		//	List Entries	//
		//					//
		//////////////////////
		global $db_my;
		// 
		//$db_my->query("SET NAMES 'utf8'", $hide_errors=0, $write_query=0);
		//
		$query="SELECT id,name,content from ". $db_my->prefix ."pages ORDER BY id ASC";

		//
		$result=$db_my->query($query, $hide_errors=0, $write_query=0);			
		//
		
		echo "<table id='settings' width='400px' style='border-style:solid;border-color:#D3D3D3;border-collapse: collapse;border-width: 1px;'>
		<tr><td></td><td></td><td>
		<form name='aendern_start' action='?p=add_page' method='post'>
			<input type='image' src='images/icons/entry_add.png' style='margin-top:4px;width:32px;height:32px;' alt='edit_event'>			
		</form>
		</td></tr>";
			
		while ($row = $db_my->fetch_assoc($result)){
			$rows[] = $row ;
		}
		foreach($rows as $row){
			echo "<tr>";
			echo "<td style='border-style:solid;border-color:#585858;border-width: 1px;'><b>".$row['name']."</b></td>";
			echo "<td style='border-style:solid;border-color:#585858;border-width: 1px;height:54px;'>".$row['content']."</td>";
			echo "<td style='border-style:solid;border-color:#585858;border-width: 1px;width:33px;'>
			<form name='aendern_start' action='?p=$target&id=".$row["id"]."' method='post'>
			<input type='hidden' name='id' value='".$row['id']."'>
			<input type='hidden' name='name' value='".$row["name"]."'>
			<input type='image' src='images/icons/edit.png' style='width:32px;height:32px;' alt='edit_event'>			
			</form>
			</a></b></td>";
			echo "</tr>";			
		}			
		echo"</table>";
}
function edit_page($id,$name,$content){
			global $db_my;
			//
			$id = $db_my->escape_string($id); 
			$name = $db_my->escape_string($name);
			$content = $db_my->escape_string($content);
			//
			if($db_my->query("UPDATE ". $db_my->prefix ."pages SET name='$name', content='$content' WHERE id='$id'")){
			return true;
			}
}
//add_page process should be updated
function add_page($name,$content){
			global $db_my;
			if ($content == "" or $name == ""){
			echo "Name oder Inhalt leer";
			exit;
			}
			//
			$datum =  date("d.m.Y",time());		
			//
			$content = $db_my->escape_string($content);
			$name = $db_my->escape_string($name);
			$query="INSERT INTO ". $db_my->prefix ."pages (id, name, content, modifiable) VALUES (0,'$name','$content','0')";
			$result=$db_my->query($query, $hide_errors=0, $write_query=0);
			echo "
			<br><h2>Eintrag hinzugefügt! </h2>
			<br>
			<div style=\"padding: 4px; border: 2px solid grey;\">
			".$content."
			</div>
			";
}
//page end
?>