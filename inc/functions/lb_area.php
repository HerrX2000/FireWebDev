<?php 
//area
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
function show_area_menu_mobile($table='',$width='',$col='')
		{
			if (find_mobile_browser()==true){
			global $db_my; 
			//$db_my->query("SET NAMES 'utf8'", $hide_errors=0, $write_query=0);
			//
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
			
			echo "<a href='".$pfad."?p=".$table."&r=".$row['name']."' style='width:".$width.";height:40%;line-height:200%;font-size:1.0em;' class='button'>".$row['name']."</a>";
			$counter = $counter + 1;
			if ($counter==$col){echo"<br>";$counter==0;}
			}
			if ($col != 0 and $num_rows % $col != 0)
			{
				echo "<a href='?' style='width:".$width.";height:40%;line-height:200%;font-size:1.0em;' class='button'>&nbsp;</a>";
			}
			echo "<here>";
		
		}
		}
function show_area_title($default='')

		{
			if (isset ($_GET["r"]))
			{
			$titel = $_GET["r"];
			}
			elseif (isset ($default))
			{
			$titel = $default;
			}
			return $titel;
		}		
		
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
				$query="SELECT id,name,content,modifiable from ". $db_my->prefix ."$table WHERE name = '$row'";
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
					echo "<div><div style='float:left;'><form action='$edit_target?table=".$table."&id=".$row['id']."&r=".$row['name']."' method='post'>
				<input type='hidden' name='table' value='".$table."'>
				<input type='hidden' name='id' value='".$row['id']."'>
				<input type='hidden' name='name' value='".$row['name']."'>
				<input type='image' src='images/icons/area_edit.png' style='wdith:32px;height:32px;' alt='edit_area'>
				</form></div>
				<div style='float:right;'>
				<input type='image' src='images/icons/area_manager.png' style='wdith:32px;height:32px;' alt='manager_area'>
				</div>
				</div>";
				}
			}
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
//area end
?>