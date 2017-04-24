<?php 
//entry		
function show_entry($table='', $id=''){
			$S_STARTZEIT = microtime(true);
			global $db_my;
			//
			if ($id=="")
				{
			die ('<br>Kein Beitrag ausgewählt');
			}
			else{
			//
			
			//$db_my->query("SET NAMES 'utf8'", $hide_errors=0, $write_query=0);
			$table = $db_my->escape_string($table);
			$id = $db_my->escape_string($id);
			if (ctype_digit($id)==true){
				$query="SELECT id,content from ". $db_my->prefix ."$table WHERE id = '$id'";
			}
			else{
				$query="SELECT id,content from ". $db_my->prefix ."$table WHERE name = '$id'";
			}
			//
			$result=$db_my->query($query, $hide_errors=1, $write_query=0);
			//
			while ($row =  $db_my->fetch_assoc($query=$result))
			{
			$rows[] = $row ;
			}
			foreach($rows as $row){
				return $row['content'];
			}
	
		}
		
		$S_ENDZEIT = microtime(true);
		$S_LAUFZEIT = $S_ENDZEIT - $S_STARTZEIT;
		$S_LAUFZEIT = round ($S_LAUFZEIT, 6);
		$S_LAUFZEIT_MS = $S_LAUFZEIT * 1000;
		
		
		}

function edit_entry($table='', $id='', $name='')

		{
			global $db_my;
			//
			if ($id=="" or $_SESSION["moderator"] != "1" and $_SESSION["admin"] != "1")
			{
			#
			if ($_SESSION["moderator"] != "1" and $_SESSION["admin"] != "1"){
			die ('<br>Keine Admin- oder Moderatorrechte');
			}
			
			if($id=="") {
					die ('<br>Kein Beitrag ausgewählt');
			}
			#		
			}
			//
			else{
					$content=$_POST['content'];
					//
					$table = $db_my->escape_string($table);
					$content = $db_my->escape_string($content);
					$id = $db_my->escape_string($id);
					$query="UPDATE ". $db_my->prefix ."$table Set content = '$content' WHERE id = '$id'";
					//
					$result=$db_my->query($query, $hide_errors=0, $write_query=0);
					if ($name != ""){
						$name = $db_my->escape_string($name);
						$query="UPDATE ". $db_my->prefix ."$table SET name = '$name' WHERE id = '$id'";
						//
						$result=$db_my->query($query, $hide_errors=0, $write_query=0);
					}
			}
	}
function add_entry($table='')
		{	
			global $db_my;
			if (isset($_POST["content"]) and $_POST["content"] != ""){
			$content=$_POST["content"];
			}
			elseif	(isset($_POST["editor"]) and $_POST["editor"] != ""){
			$content=$_POST["editor"];
			}	
			$spam_protection = $_POST["email2"];			
			
			//
			/* check connection */
			if (mysqli_connect_errno()) {
				printf("Connect failed: %s\n", mysqli_connect_error());
				exit();
			}

				
			//
			if (isset ($content) and $_SESSION["admin"]==1)
			{
					$datum =  date("d.m.Y",time());		
				$content = $db_my->escape_string($content);
			//
			if ($spam_protection != '') {
			die ('<br>'.'Spam');
			}
			//
			$table = $db_my->escape_string($table);
			$query="insert into ". $db_my->prefix ."$table values (0,'".$content.$datum."','".$_SESSION["username"]."','0')";
			$result=$db_my->query($query, $hide_errors=0, $write_query=0);
			echo "
			<script src='/tinymce/tinymce.min.js'></script>
			<script>tinymce.init({
				selector:'.tinymce',
				height : 400,
			});
			</script>
			<br><h2>News gesendet! </h2>
			<br>
			<div style=\"padding: 4px; border: 2px solid grey;\">

			".$content."
			</div>
			<a href='index.php' class='button'><h3>Weiter</h3></a>
			";
			}	
		}
function remove_entry($table='', $id='')
		{
			global $db_my;
			//

			if ($id=="" or $_SESSION["moderator"] != "1" and $_SESSION["admin"] != "1")
			{
			#
			
			if ($_SESSION["moderator"] != "1" and $_SESSION["admin"] != "1"){
			die ('<br>Keine Admin- oder Moderatorrechte');
			}
			
			if($id=="") {
					die ('<br>Kein Beitrag ausgewählt');
			}
			#		
			}
			//
			else{
			//$db_my->query("SET NAMES 'utf8'", $hide_errors=0, $write_query=0);
			//
			$table = $db_my->escape_string($table);
			$id = $db_my->escape_string($id);
			$query="UPDATE ". $db_my->prefix ."$table Set removed = '1' WHERE id = '$id'";

			//
			$result=$db_my->query($query, $hide_errors=0, $write_query=0);
		}
	}
	
function delete_entry($table='', $id='')
		{
			global $db_my;
			//
			if (!$id=="") {
			die ('<br>'.' Error: ');
			}
			//
			else{
			//$db_my->query("SET NAMES 'utf8'", $hide_errors=0, $write_query=0);
			//
			$table = $db_my->escape_string($table);
			$id = $db_my->escape_string($id);
			$query="DELETE FROM ". $db_my->prefix ."$table WHERE id = '$id'";
			//
			$result=$db_my->query($query, $hide_errors=0, $write_query=0);
			}
		}
//Entries end
?>