<?php 
//area
class area{
	function init($table=''){
		$init=$table;
		$this->init=$init;
		global $c;
		global $db_my;
		
		$table_n = $table;
		$table = $db_my->escape_string($table);
		$table = "area_".$table;

		$query="SELECT id,name,content from ". $db_my->prefix ."$table ORDER by ID ";

		//
		$area_table=$db_my->query($query, $hide_errors=1, $write_query=0);
		
	
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
		//
		if($db_my->num_rows($result)!=0){
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
				$this->content = $row['content'];
				$content = $row['content'];
				$content = explode(":php_code:", $content);
				foreach ($content as $each_content)
				{
					$this->each_content=$each_content;
				}
			}
			$return = array("area" => $area_table, "table" => $table_n, "id" => $row['id'],"name" => $row['name'], "modifiable" => $row['modifiable']);
			$this->cur=$return;
			return $return;
		}
		else{
			$return = array("area" => $area_table, "table" => 0,"id" => null,"name" => null, "modifiable" => null);
			$this->each_content=null;
			$this->cur=$return;
			return false;
		}
		
	}
	
	function execute(){
		$content = $this->each_content;
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
	}
	
	function show(){
		$content = $this->each_content;
		echo $content;
	}
	
	function menu(){
		global $db_my;
		global $c;
		$result=$this->cur['area'];
		//
		$num_rows=$db_my->num_rows($result);
		//
		while ($row = $db_my->fetch_assoc($result))
		{
		$rows[] = $row ;
		}
		$counter=0;
		$array = array();
		foreach($rows as $row){
		$array[$counter] = array();
		array_push($array[$counter],$c->get('p',$this->cur['table']).$c->get('r', $row['name']));
		array_push($array[$counter],$row['name']);
		$counter++;
		}
		return $array;
	}
}


function show_area_entry($table='',$default='')

		{
			global $db_my;
			global $c;
			//$db_my->query("SET NAMES 'utf8'", $hide_errors=0, $write_query=0);
			
			$table_n = $table;
			$table = $db_my->escape_string($table);
			$table = "area_".$table;
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
				$edit_target=$c->a('area_edit').$c->get('inline',0);
			}
			else{
				$edit_target=$c->a('area_edit');
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
			global $user;
			if ($user->verify(1)===true)
			{
				if ($row['modifiable']==1){
					echo "<div><div style='float:left;'>
				<form action='$edit_target".$c->get('table',$table).$c->get('id',$row['id']).$c->get('r',$row['name'])."' method='post'>
				<input type='hidden' name='table' value='".$table_n."'>
				<input type='hidden' name='id' value='".$row['id']."'>
				<input type='hidden' name='name' value='".$row['name']."'>
				<input type='image' src='".FW_CLIENT_ROOT."images/icons/area_edit.png' style='wdith:32px;height:32px;' alt='edit_area'>
				</form>
				</div>
				<div style='float:right;'>
				<form action='".$c->a('area_manager').$c->get('t',$table_n)."' method='post'>
				<input type='hidden' name='table' value='".$table_n."'>
				<input type='image' src='".FW_CLIENT_ROOT."images/icons/area_manager.png' style='wdith:32px;height:32px;' alt='manager_area'>
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
			global $c;
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
				echo "<a href='".$c->get('p',$table_n,1).$c->get('r',$row['name'])."' class='button'>".$row['name']."</a><br>";
				}
			}
		}
function area_menu($table='')
		{
			global $db_my; 
			global $c;
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
			$array = array();
			foreach($rows as $row){
			$array[$counter] = array();
			array_push($array[$counter],$c->get('p',$table_n).$c->get('r', $row['name']));
			array_push($array[$counter],$row['name']);
			$counter++;
			}
			return $array;
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
			$first=true;
			foreach($rows as $row){
				if (isset ($_GET['r']) and $_GET['r']===$row['name']){
					echo "<a href='".$pfad."?p=".$table_n."&r=".$row['name']."' style='width:".$width.";font-size:1.0em;margin:0;outline-style: solid;outline-width: 1px;outline-color: #848484;color:black;background-color:rgba(244,164,96, 0.75);' class='button_theme'>".$row['name']."</a>";
				}
				elseif (!isset ($_GET['r']) and $first){
					echo "<a href='".$pfad."?p=".$table_n."&r=".$row['name']."' style='width:".$width.";font-size:1.0em;margin:0;outline-style: solid;outline-width: 1px;outline-color: #848484;color:black;background-color:rgba(244,164,96, 0.75);' class='button_theme'>".$row['name']."</a>";
					$first = false;
				}
				else{
					echo "<a href='".$pfad."?p=".$table_n."&r=".$row['name']."' style='width:".$width.";font-size:1.0em;' class='button'>".$row['name']."</a>";
				}			
			$counter ++;
					if ($counter==$col){
					echo"<br>";$counter==0;
				}
			}
			if ($col != 0 and $num_rows % $col != 0)
			{
				echo "<a href='#' style='width:".$width.";height:40%;line-height:200%;font-size:1.0em;' class='button'>&nbsp;</a>";
			}
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
			$table = "area_".$table;
			if (isset ($_POST['content']) and $_POST['content'] != ""){
				//
				$content=$_POST['content'];
				$content = $db_my->escape_string($content);
				//
				$query="UPDATE ". $db_my->prefix ."$table SET content = '$content' WHERE id = '$id'";
				//
				$result=$db_my->query($query, $hide_errors=0, $write_query=0);
			}
			if (isset ($_POST['name']) and $_POST['name'] != ""){
				//
				$name=$_POST['name'];
				$name = $db_my->escape_string($name);
				//
				$query="UPDATE ". $db_my->prefix ."$table SET name = '$name' WHERE id = '$id'";
				//
				$result=$db_my->query($query, $hide_errors=0, $write_query=0);
			}
	}	
function show_area_entries($table, $target){
		$table = "area_".$table;
		//////////////////////
		//					//
		//	List Settings	//
		//					//
		//////////////////////
		global $db_my;
		global $c;
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
			<td><a href='".$c->get('t',$_GET['t'],1).$c->get('add','true')."'><img src='".FW_CLIENT_ROOT."images/icons/add.png' style='width:32px;height:32px;' alt='add_entry'></a></td>";
			echo "</tr>";		
		while ($row = $db_my->fetch_assoc($result)){
			$rows[] = $row ;
		}
		if(isset($rows)){		
			foreach($rows as $row){
				echo "<tr style='border-style:solid;border-color:#585858;border-width: 1px;height:54px;'>
				<form name='edit' action='".$c->get('t',$_GET['t'],1).$c->get('t',$_GET['t']).$c->get('edit','true')."' method='post'>
				<input type='hidden' name='id' value='".$row['id']."'>
				<td><input type='text' name='id_new' value='".$row['id']."'></td>
				<td><input type='text' name='title'' value='".$row['title']."'></td>
				<td><input type='text' name='name' value='".$row['name']."'></td>
				<td style='border-style:solid;border-color:#585858;border-width: 1px;width:33px;'>
				<input type='image' src='".FW_CLIENT_ROOT."images/icons/edit.png' style='width:32px;height:32px;' alt='edit_entry' onclick=\"return confirm('Ändern?')\">			
				</form>
				<form name='delete' action='".$c->get('t',$_GET['t'],1).$c->get('t',$_GET['t']).$c->get('delete','true')."' method='post'>
				<input type='hidden' name='id' value='".$row['id']."'>
				<td style='border-style:solid;border-color:#585858;border-width: 1px;width:33px;'>
				<input type='image' src='".FW_CLIENT_ROOT."images/icons/delete.png' style='width:32px;height:32px;' alt='delete_entry' onclick=\"return confirm('Löschen?')\">		
				</form>
				</td>
				</tr>";			
			}
		}else{
			echo "<tr><td>Keine Einträge</td></tr>";
		}
		echo"</table>
		Hint: id1 = default
		";
}
function edit_area_entries($table, $id){
			global $db_my;
			$table_n = $table;
			$table = $db_my->escape_string($table);
			$table = "area_".$table;
			
			//
			$id = $db_my->escape_string($id);
			$id_new = $db_my->escape_string($_POST['id_new']); 
			$name = $db_my->escape_string($_POST['name']);
			$title = $db_my->escape_string($_POST['title']);
			//
			if($db_my->query("UPDATE ". $db_my->prefix ."$table SET id='$id_new', title='$title', name='$name' WHERE id='$id'")){
				return true;
				//allways returns true 
			}
}
function add_area_entry($table){
		global $db_my;
		$table_n = $table;
		$table = $db_my->escape_string($table);
		$table = "area_".$table;

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
		$table_n = $table;
		$table = $db_my->escape_string($table);
		$table = "area_".$table;
		
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