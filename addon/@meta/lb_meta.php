<?php
//Proto Type

class meta{
	function output($db_my, $type, $name){
		$table = "entries_news";
		$id = "1";
		$db_my = $db_my;
		if ($type=="page"){
			//
			//
			//$db_my->query("SET NAMES 'utf8'", $hide_errors=0, $write_query=0);
			$table = $db_my->escape_string($table);
			$name = $db_my->escape_string($name);
			if (ctype_digit($id)==true){
				$query="SELECT meta_description,meta_keywords,meta_robots from ".$db_my->prefix ."at_meta WHERE name = '$name'";
			}
			//
			$result = $db_my->query($query, $hide_errors=1, $write_query=0);
			//
			if(mysqli_num_rows($result) != 0){
			while ($row =  $db_my->fetch_assoc($query=$result))
			{
			$rows[] = $row;
			}
			foreach($rows as $row){
				$row['meta_description'];
				$row['meta_keywords'];
				$row['meta_robots'];
			}
			return $row;
			}
		}
	}
	function show_meta_list($target){
			//////////////////////
			//					//
			//	List Entries	//
			//					//
			//////////////////////
			global $db_my;
			// 
			//$db_my->query("SET NAMES 'utf8'", $hide_errors=0, $write_query=0);
			//
			$query="SELECT id,type,name,meta_description,meta_keywords,meta_robots from ". $db_my->prefix ."at_meta ORDER BY id ASC";

			//
			$result=$db_my->query($query, $hide_errors=0, $write_query=0);			
			//
			
			echo "
			<table id='settings' width='100%' style='border-style:solid;border-color:#D3D3D3;border-collapse: collapse;border-width: 1px;'>
				<tr>
				<td colspan='100%'><h1>@Meta Einstellungen</h1></td>
			</tr>
			<tr>
				<td style='border-style:solid;border-color:#585858;border-width: 1px;'>id</td>
				<td style='border-style:solid;border-color:#585858;border-width: 1px;'>type</td>
				<td style='border-style:solid;border-color:#585858;border-width: 1px;'>name</td>
				<td style='border-style:solid;border-color:#585858;border-width: 1px;height:54px;'>meta_description</td>
				<td style='border-style:solid;border-color:#585858;border-width: 1px;height:54px;'>meta_keywords</td>
				<td style='border-style:solid;border-color:#585858;border-width: 1px;height:54px;'>meta_robots</td>
				<td>
				<form name='aendern_start' action='?p=add_meta' method='post'>
					<input type='image' src='add.png' style='margin-top:4px;width:32px;height:32px;' alt='edit_event'>			
				</form>
				</td>
			</tr>

			";
				
			while ($row = $db_my->fetch_assoc($result)){
				$rows[] = $row ;
			}
			foreach($rows as $row){
				echo "<tr>";
				echo "<td style='border-style:solid;border-color:#585858;border-width: 1px;'><b>".$row['id']."</b></td>";
				echo "<td style='border-style:solid;border-color:#585858;border-width: 1px;'><b>".$row['type']."</b></td>";
				echo "<td style='border-style:solid;border-color:#585858;border-width: 1px;'><b>".$row['name']."</b></td>";
				echo "<td style='border-style:solid;border-color:#585858;border-width: 1px;height:54px;'>".$row['meta_description']."</td>";
				echo "<td style='border-style:solid;border-color:#585858;border-width: 1px;height:54px;'>".$row['meta_keywords']."</td>";
				echo "<td style='border-style:solid;border-color:#585858;border-width: 1px;height:54px;'>".$row['meta_robots']."</td>";
				echo "<td style='border-style:solid;border-color:#585858;border-width: 1px;width:33px;'>
				<form name='aendern_start' action='?p=$target&id=".$row["id"]."' method='post'>
				<input type='hidden' name='id' value='".$row['id']."'>
				<input type='hidden' name='name' value='".$row['name']."'>
				<input type='hidden' name='type' value='".$row['type']."'>
				<input type='hidden' name='meta_description' value='".$row['meta_description']."'>
				<input type='hidden' name='meta_keywords' value='".$row['meta_keywords']."'>
				<input type='hidden' name='meta_robots' value='".$row['meta_robots']."'>
				
				<input type='image' src='edit.png' style='width:32px;height:32px;' alt='edit_event'>			
				</form>
				</td>";
				echo "</tr>";			
			}			
			echo"</table>";
	}
	function edit_meta($id,$name,$type, $meta_description, $meta_keywords, $meta_robots){
				global $db_my;
				//
				$id = $_POST['id']; 
				$name = $_POST['name'];
				$type = $_POST['type'];
				$meta_description = $_POST['meta_description'];
				$meta_keywords = $_POST['meta_keywords'];
				$meta_robots = $_POST['meta_robots'];
				//
				if($db_my->query("UPDATE ".$db_my->prefix ."at_meta SET name='$name', type='$type', meta_description='$meta_description', meta_robots='$meta_robots' WHERE id='$id'")){
				return true;
				}
	}
	//add_meta process should be updated
	function add_meta($name,$type, $meta_description, $meta_keywords, $meta_robots){
				global $db_my;
				if ($name == "" or $type == ""){
				echo "Name oder Type leer";
				exit;
				}
				//
				$datum =  date("d.m.Y",time());		
				//
				$name = $db_my->escape_string($name);
				$type =$db_my->escape_string($type);
				$meta_description = $db_my->escape_string($meta_description);
				$meta_keywords = $db_my->escape_string($meta_keywords);
				$meta_robots = $db_my->escape_string($meta_robots);			
				$query="INSERT INTO ".$db_my->prefix ."at_meta (name,type, meta_description, meta_keywords, meta_robots) VALUES ('$name','$type', '$meta_description', '$meta_keywords', '$meta_robots')";
				if($db_my->query($query)){
					return true;
				}
	}

	function show_meta_form(){
			echo "
			<h3 style='text-align:center;'>Eintrag bearbeiten?</h3>
			<table id='settings' style='width:100%;min-height:80px;border-style:solid;border-color:#D3D3D3;border-collapse: collapse;border-width: 1px;'>
			<tr>
				<form name='setting_form' id='setting_form' action='?p=edit_meta_submit&submit=1' method='post'>
				<input type='hidden' name='id' value='".$_POST['id']."'>
				<td style='border-style:solid;border-color:#585858;border-width: 1px;'>
					Name:<input type='text' name='name' value='".$_POST['name']."'>
				</td>	
				<td style='border-style:solid;border-color:#585858;border-width: 1px;'>
					Type:<input type='text' name='type' value='".$_POST['type']."'>
				</td>
				<td style='border-style:solid;border-color:#585858;border-width: 1px;'>
					meta_description:<input type='text' name='meta_description' value='".$_POST['meta_description']."'>
				</td>
				<td style='border-style:solid;border-color:#585858;border-width: 1px;'>
					meta_description:<input type='text' name='meta_keywords' value='".$_POST['meta_keywords']."'>
				</td>
				<td style='border-style:solid;border-color:#585858;border-width: 1px;'>
					meta_description:<input type='text' name='meta_robots' value='".$_POST['meta_robots']."'>
				</td>
				</form>
			</tr>
			</table>
			<br>
			<br>
			<a href='#' onclick='document.setting_form.submit();' class='button'>Senden</a> 
			</table>";
			}
	function show_add_meta_form($target){
		echo"
		<table id='settings' style='width:100%;min-height:80px;border-style:solid;border-color:#D3D3D3;border-collapse: collapse;border-width: 1px;'>
			<tr>
				<form name='add_meta' id='add_meta' action='?p=$target&submit=1' method='post'>
				<input type='hidden' name='id'  placeholder='id'>
				<td style='border-style:solid;border-color:#585858;border-width: 1px;'>
					Name:<input type='text' name='name'  placeholder='name'>
				</td>	
				<td style='border-style:solid;border-color:#585858;border-width: 1px;'>
					Type:<input type='text' name='type'  placeholder='type'>
				</td>
				<td style='border-style:solid;border-color:#585858;border-width: 1px;'>
					meta_description:<input type='text' name='meta_description' placeholder='meta_description'>
				</td>
				<td style='border-style:solid;border-color:#585858;border-width: 1px;'>
					meta_description:<input type='text' name='meta_keywords' placeholder='meta_keywords'>
				</td>
				<td style='border-style:solid;border-color:#585858;border-width: 1px;'>
					meta_description:<input type='text' name='meta_robots'  placeholder='meta_robots'>
				</td>
				<tr><td>
				<input type='submit' value='Submit' onclick=\"confirm('Finished?')\">	
				</td></tr>
				</form>
			</tr>
			</table>
			
		";
	}			
}
?>
