<?php

function show_edit_settings_form(){
	global $db_my;
	global $c;
	$id=$_POST['id'];
	$title=$_POST['title'];
	$name=$_POST['name'];
	$value = htmlspecialchars($_POST['value'], ENT_QUOTES);
	echo "<form name='settings_form' id='settings_form' action='".$c->p('edit_settings_submit').$c->get('submit',1)."' method='post'>
		<input type='hidden' name='id' value='".$_POST['id']."'>
		<input type='hidden' name='title' value='".$_POST['title']."'>
		<input type='hidden' name='name' value='".$_POST['name']."'>
		<table id='settings' style='width:100%;border-style:solid;border-color:#D3D3D3;border-collapse: collapse;border-width: 1px;'>
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
			
		case "home_name":	
			echo "<td style='width:70%;border-style:solid;border-color:#585858;border-width: 1px;'>
					<input type='text' name='value' value=\"".$value."\">
				</td>";
			break;
			
		default:
			echo "
			<tr>
				<td style='width:70%;border-style:solid;border-color:#585858;border-width: 1px;'>
					<textarea style='height:160px;width:98%;max-width:100%;resize:vertical;' name='value' form='settings_form'>".$value."</textarea>
				</td>
			</tr>
			";	
	}
	echo"
	</table>
	</form>
	<a href='#' onclick='document.settings_form.submit();' style='width:100%;' class='button'>Senden</a> 
	<a href='".$c->ref('administration','edit_settings')."' style='width:100%;' class='button'>Zurück</a> 	";
}

function show_page_form(){
	global $c;
		echo "
		<h3 style='text-align:center;'>Eintrag bearbeiten?</h3>
		<form name='setting_form' id='setting_form' action='".$c->p('edit_page_submit').$c->get('submit',1)."' method='post'>
		Name:<input type='text' name='name' value='".$_POST['name']."'>
		<input type='hidden' name='id' value='".$_POST['id']."'>
		<textarea style='height:160px;width:98%;max-width:100%;resize:vertical;' name='content' form='setting_form'>".show_page($table="pages",$id=$_POST['id'])."</textarea>
		</form>
		<br>
		<br>
		<a href='#' onclick='document.setting_form.submit();' class='button' style='width:100%;'>Senden</a> 
		<a href='".$c->p('edit_page')."' class='button' style='width:100%;'>Zurück</a>";
		}
function show_create_table_form($target, $type){
	global $c;
	echo"
	<form name='create_table' id='create_table' action='".$c->p($target).$c->get('submit',1)."' method='post'>
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
	global $c;
	echo"
	<form name='create_table' id='create_table' action='".$c->p($target).$c->get('submit',1)."' method='post'>
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
	global $c;
	echo"
	<form name='add_page' id='add_page' action='".$c->p($target).$c->get('submit',1)."' method='post'>
	<input type='text' name='name' ";
	if(isset($_GET['name'])){
		echo "value='".$_GET['name']."'";
	}
	echo"placeholder='name' required>
	<textarea style='height:160px;width:98%;max-width:100%;resize:vertical;' name='content' form='add_page'></textarea>
	<input type='submit' value='Submit' onclick=\"confirm('Finished?')\">	
	</form>
	";
}			
?>