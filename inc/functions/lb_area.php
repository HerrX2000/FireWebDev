<?php 
//area
function show_area_entry($table='',$default='')

		{
			global $db_my;
			//$db_my->query("SET NAMES 'utf8'", $hide_errors=0, $write_query=0);
			
			$table = "area_".$table;
			$table = $db_my->escape_string($table);
			if (isset ($_GET["r"]))
			{
				$row = $_GET["r"];
				$row = $db_my->escape_string($row);
				$query="SELECT id,name,content,modifiable from ". $db_my->prefix ."$table WHERE name = '$row' or title = '$row'";
			}
			elseif (isset ($default) and $default !== "")
			{

				$row = $default;
				$row = $db_my->escape_string($row);
				$query="SELECT id,name,content,modifiable from ". $db_my->prefix ."$table WHERE name = '$row'";
			}
			else{
				$query="SELECT id,name,content,modifiable from ". $db_my->prefix ."$table WHERE id = '1'";
			}

			//
			$result=$db_my->query($query, $hide_errors=1, $write_query=0);
			
			//
			if (!$result){
				echo $query;
				echo"Error: table '$table' probably does not exist";
				exit;
			}
			
			if (find_mobile_browser(false)==true){
				$edit_target="area_edit.php?exp=0";
			}
			else{
				$edit_target="area_edit.php?exp=1";
			}
			
			//
			while ($row = $db_my->fetch_assoc($result))
			{
			$rows[] = $row ;
			}
			// Errorhandel
			if(!isset($rows)) {
				echo "Nicht gefunden";
				exit;
			}
			foreach($rows as $row){
			$content = $row['content'];
			$content = explode(":php_code:", $content);
			foreach ($content as $each_content)
			{
				if(strpos(" ".$each_content, "start:")==false and strpos($each_content, ":end")==false)
				{
					echo $each_content;
				}
				elseif(strpos($each_content, "start:")!==false and strpos($each_content, ":end")!==false)
				{
					$delete = array ("start:",":end");
					$each_content = str_replace ($delete, "", $each_content );
					$each_content = explode(":", $each_content);
					
					if (is_array($each_content))
					{
					foreach ($each_content as $each_function)
					{
					eval($each_function);
					}
					}
				}
			
			}
			if (@$_SESSION["moderator"] == "1" or @$_SESSION["admin"] == "1")
			{
				if ($row['modifiable']==1){
					echo "<div><div style='float:left;'>
				<form action='$edit_target?table=".$table."&id=".$row['id']."&r=".$row['name']."' method='post'>
				<input type='hidden' name='table' value='".$table."'>
				<input type='hidden' name='id' value='".$row['id']."'>
				<input type='hidden' name='name' value='".$row['name']."'>
				<input type='image' src='images/icons/area_edit.png' style='wdith:32px;height:32px;' alt='edit_area'>
				</form>
				</div>
				<div style='float:right;'>
				<form action='area_manager.php?t=".$table."' method='post'>
				<input type='hidden' name='table' value='".$table."'>
				<input type='image' src='images/icons/area_manager.png' style='wdith:32px;height:32px;' alt='manager_area'>
				</form>
				</div>
				</div>";
				}
			}
			}
			
		}

function show_area_menu($table='')

		{
			global $db_my;
			//
			//$db_my->query("SET NAMES 'utf8'", $hide_errors=0, $write_query=0);
			//
			$table_n = $table;
			$table = "area_".$table;
			$table = $db_my->escape_string($table);
			$query="SELECT id,name,content from ". $db_my->prefix ."$table ORDER by ID ";

			//
			$result=$db_my->query($query, $hide_errors=1, $write_query=0);
			if (!$result){
				echo $query;
				echo"Error: table '$table' probably does not exist";
				exit;
			}
			if($db_my->num_rows($result)!=0){				
				//
				
				$dateiname=$_SERVER['SCRIPT_NAME'];  
				$path = pathinfo($dateiname);
				$pfad=$path["filename"].".".$path["extension"];
				
				while ($row = $db_my->fetch_assoc($result))
				{
				$rows[] = $row ;
				}
				
				foreach($rows as $row){
				echo "<a href='".$pfad."?p=".$table_n."&r=".$row['name']."' class='button'>".$row['name']."</a><br>";
				}
			}
		}
function show_area_menu_mobile($table='',$width='98%',$col='1')
		{
			global $db_my; 
			//$db_my->query("SET NAMES 'utf8'", $hide_errors=0, $write_query=0);
			//
			$table_n = $table;
			$table = $db_my->escape_string($table);
			$table = "area_".$table;
			$query="SELECT id,name,content from ". $db_my->prefix ."$table ORDER by ID ";

			//
			$result=$db_my->query($query, $hide_errors=1, $write_query=0);
			//
			$num_rows=$db_my->num_rows($result);
		
			//
			
			$dateiname=$_SERVER['SCRIPT_NAME'];  
			$path = pathinfo($dateiname);
			$pfad=$path["filename"].".".$path["extension"];
		
			while ($row = $db_my->fetch_assoc($result))
			{
			$rows[] = $row ;
			}
			$counter=0;
			foreach($rows as $row){
			
			echo "<a href='".$pfad."?p=".$table_n."&r=".$row['name']."' style='width:".$width.";height:40%;line-height:200%;font-size:1.0em;' class='button'>".$row['name']."</a>";
			$counter = $counter + 1;
				if ($counter==$col){
					echo"<br>";$counter==0;
				}
			}
			if ($col != 0 and $num_rows % $col != 0)
			{
				echo "<a href='#' style='width:".$width.";height:40%;line-height:200%;font-size:1.0em;' class='button'>&nbsp;</a>";
			}
			echo "<here>";
		}
function area_title($default='', $root=false)
		{
			if (isset ($_GET["r"])){
				$title = $_GET["r"];
			}
			elseif (isset ($_GET["p"])){
				$title = $_GET["p"];
				$title = ucwords($title);
			}
			elseif (isset ($default)){
				$title = $default;
			}
			if ($root == true and isset ($_GET["r"])){
				$title_root = $_GET["p"];
				$title_root = ucwords($title_root);
				if ($title_root == $title){
					return $title;
				}
				$title = $title_root." - ".$title;
				return $title;
			}
			else{
				return $title;	
			}
		}		
	
function edit_area_entry($table='', $id=''){
			global $db_my;
			if (isset ($_POST['content']) and $_POST['content'] != ""){
				//
				$content=$_POST['content'];
				//
				$query="UPDATE ". $db_my->prefix ."$table SET content = '$content' WHERE id = '$id'";
				//
				$result=$db_my->query($query, $hide_errors=0, $write_query=0);
			}
			if (isset ($_POST['name']) and $_POST['name'] != ""){
				//
				$name=$_POST['name'];
				//
				$query="UPDATE ". $db_my->prefix ."$table SET name = '$name' WHERE id = '$id'";
				//
				$result=$db_my->query($query, $hide_errors=0, $write_query=0);
			}
	}	
function show_area_entries($table, $target){
		//////////////////////
		//					//
		//	List Settings	//
		//					//
		//////////////////////
		global $db_my;
		// 
		//$db_my->query("SET NAMES 'utf8'", $hide_errors=0, $write_query=0);
		//

		$query="SELECT id,name,title,content from ". $db_my->prefix ."$table ORDER BY id ASC";
		
		//
		$result=$db_my->query($query, $hide_errors=0, $write_query=0);			
		//
		
		echo "<table id='settings' style='width:100%;border-style:solid;border-color:#D3D3D3;border-collapse: collapse;border-width: 1px;'>";
			echo "<tr>
			<td style='border-style:solid;border-color:#585858;border-width: 1px;'>id</td>
			<td style='border-style:solid;border-color:#585858;border-width: 1px;height:54px;'>title</td>
			<td style='border-style:solid;border-color:#585858;border-width: 1px;height:54px;'>name</td>
			<td></td>
			<td><a href='?t=".$_GET['t']."&add=true'><img src='images/icons/add.png' style='width:32px;height:32px;' alt='add_entry'></a></td>";
			echo "</tr>";		
		while ($row = $db_my->fetch_assoc($result)){
			$rows[] = $row ;
		}
		foreach($rows as $row){
			echo "<tr style='border-style:solid;border-color:#585858;border-width: 1px;height:54px;'>
			<form name='edit' action='?t=".$_GET['t']."&id=".$row["id"]."&edit=true' method='post'>
			<input type='hidden' name='id' value='".$row['id']."'>
			<td><input type='text' name='id_new' value='".$row['id']."'></td>
			<td><input type='text' name='title'' value='".$row['title']."'></td>
			<td><input type='text' name='name' value='".$row['name']."'></td>
			<td style='border-style:solid;border-color:#585858;border-width: 1px;width:33px;'>
			<input type='image' src='images/icons/edit.png' style='width:32px;height:32px;' alt='edit_entry' onclick=\"return confirm('')\">			
			</form>
			<form name='delete' action='?t=".$_GET['t']."&id=".$row["id"]."&delete=true' method='post'>
			<input type='hidden' name='id' value='".$row['id']."'>
			<td style='border-style:solid;border-color:#585858;border-width: 1px;width:33px;'>
			<input type='image' src='images/icons/delete.png' style='width:32px;height:32px;' alt='delete_entry' onclick=\"return confirm('')\">		
			</form>
			</td>";
			echo "</tr>";			
		}			
		echo"</table>
		id1 = default
		";
}
function edit_area_entries($table, $id){
		global $db_my;
			//
			$id = $db_my->escape_string($id);
			$id_new = $db_my->escape_string($_POST['id_new']); 
			$name = $db_my->escape_string($_POST['name']);
			$title = $db_my->escape_string($_POST['title']);
			//
			if($db_my->query("UPDATE ". $db_my->prefix ."$table SET id='$id_new', title='$title', name='$name' WHERE id='$id'")){
				echo "Query: UPDATE ". $db_my->prefix ."$table SET id='$id_new', title='$title', name='$name' WHERE id='$id'";
				return true;
				//allways returns true 
			}
}
function add_area_entry($table){
		global $db_my;
			//
			//
			if($db_my->query("INSERT INTO ". $db_my->prefix ."$table (id) VALUES (null)")){
				echo "Query: INSERT INTO ". $db_my->prefix ."$table (id) VALUES (null)";
				return true;
				//allways returns true 
			}
}
function delete_area_entry($table, $id){
		global $db_my;
			//
			$id = $db_my->escape_string($id); 
			//
			if($db_my->query("DELETE FROM ". $db_my->prefix ."$table WHERE id='$id'")){
				echo "Query: DELETE FROM ". $db_my->prefix ."$table WHERE id='$id'";
				return true;
				//allways returns true 
			}
}
//area end
?>