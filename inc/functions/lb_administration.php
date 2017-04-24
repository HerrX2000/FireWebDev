<?php

function show_edit_settings_form(){
	$id=$_POST['id'];
	$title=$_POST['title'];
	$name=$_POST['name'];
	echo "<form name='settings_form' id='settings_form' action='?p=edit_settings_submit&submit=1' method='post'>
		<input type='hidden' name='id' value='".$_POST['id']."'>
		<input type='hidden' name='title' value='".$_POST['title']."'>
		<input type='hidden' name='name' value='".$_POST['name']."'>
		<table id='settings' style='border-style:solid;border-color:#D3D3D3;border-collapse: collapse;border-width: 1px;'>
		<tr>
		<td style='border-style:solid;border-color:#585858;border-width: 1px;'>
					<b>".$_POST['title']."</b><br>$id: '$name'
				</td>";
				
	switch ($_POST['name']) {
		case "status":
			echo "
				<td style='width:30%;border-style:solid;border-color:#585858;border-width: 1px;'>
				<input type='radio' name='value'
				value='1' checked>Online
				<input type='radio' name='value'
				value='0'>Offline
				</td>";
			break;
			
		case "status_reason":
			echo "
				<td style='width:70%;border-style:solid;border-color:#585858;border-width: 1px;'>
				<textarea style='height:160px;width:98%;max-width:100%;resize:vertical;' name='value' form='settings_form'>Grund:<br>Die Website ist zur Zeit wegen Wartungsarbeiten nur für User erreichbar.<br><br>Voraussichtlich
				<br>Von: 00:00 Uhr
				<br>Bis: 00:00 Uhr</textarea>
				</td>";
			break;
			
		case "root_name":
			echo "<td style='width:70%;border-style:solid;border-color:#585858;border-width: 1px;'>
					<input type='text' name='value' value='".$_POST['value']."'>
				</td>";
			break;
			
		default:
			echo "
			<tr>
				<td style='width:70%;border-style:solid;border-color:#585858;border-width: 1px;'>
					<textarea style='height:160px;width:98%;max-width:100%;resize:vertical;' name='value' form='settings_form'>".$_POST["value"]."</textarea>
				</td>
			</tr>
			";	
	}
	echo"
	</tr>
	</table>
	</form>
	<a href='#' onclick='document.settings_form.submit();' class='button'>Senden</a> 
	<a href='administration.php?p=edit_settings' class='button'>Zurück</a> 	";
}

function show_page_form(){
		echo "
		<h3 style='text-align:center;'>Eintrag bearbeiten?</h3>
		<table id='settings' style='width:100%;height:160px;border-style:solid;border-color:#D3D3D3;border-collapse: collapse;border-width: 1px;'>
		<tr>
			<form name='setting_form' id='setting_form' action='?p=edit_page_submit&submit=1' method='post'>
			<td style='width:30%;border-style:solid;border-color:#585858;border-width: 1px;'>
				<input type='text' name='name' value='".$_POST['name']."'>
			</td>	
				<input type='hidden' name='id' value='".$_POST['id']."'>
			</form>
			<td style='width:70%;border-style:solid;border-color:#585858;border-width: 1px;'>
				<textarea style='height:160px;width:98%;max-width:100%;resize:vertical;' name='content' form='setting_form'>".show_entry($table="pages",$id=$_POST['id'])."</textarea>
			</td>
		</tr>
		</table>
		<br>
		<br>
		<a href='#' onclick='document.setting_form.submit();' class='button'>Senden</a> 
		<a href='administration.php?p=edit_page' class='button'>Zurück</a>
		</table>";
		}
function show_create_table_form($target, $type){
	echo"
	<form name='create_table' id='create_table' action='?p=$target&submit=1' method='post'>
	<input type='hidden' name='type' value='$type'>
	<br>
	<fieldset>
	<legend><h2>Erstelle Tabelle: $type</h2></legend>
	<table>

	<tr><td>Name:</td> <td><input type='text' name='name' placeholder='$type _name' required>	</td></tr>
	
	<tr><td></td> <td>In der Datenbank wird dann eine neue Tabel erstellt.<br></td></tr>

	<tr><td>Menüeintrag:</td> <td><input type='checkbox' name='menu_entry' value='1'></td></tr>
	<tr><td></td> <td>Erstellt einen Eintrag in den Einstellungen einen Eintrag für den neuen Bereich</td></tr>

	<tr><td></td><td><input type='submit' value='Submit' onclick=\"confirm('Create table?')\"></fieldset></td></tr>
	</table>
	</fieldset>
	</form>";
}
function show_delete_table_form($target, $type){
	echo"
	<form name='create_table' id='create_table' action='?p=$target&submit=1' method='post'>
	<input type='hidden' name='type' value='$type'>
	<br>
	<fieldset>
	<legend><h2>Lösche Tabelle: $type</h2></legend>
	<table>

	<tr><td>Name:</td> <td><input type='text' name='name' placeholder='$type _name' required>	</td></tr>
	

	<tr><td>Dauerhaft:</td> <td><input type='checkbox' name='delete' value='1' onclick=\"confirm('Wird die Tabelle unwiederruflich löschen')\"></td></tr>

	<tr><td></td><td><input type='submit' value='Submit' onclick=\"confirm('Delete table?')\"></fieldset></td></tr>
	</table>
	</fieldset>
	</form>";
}	
function show_add_page_form($target){
	echo"
	<form name='add_page' id='add_page' action='?p=$target&submit=1' method='post'>
	<input type='text' name='name' placeholder='name' required>
	<textarea style='height:160px;width:98%;max-width:100%;resize:vertical;' name='content' form='add_page'></textarea>
	<input type='submit' value='Submit' onclick=\"confirm('Finished?')\">	
	</form>
	";
}			
?>