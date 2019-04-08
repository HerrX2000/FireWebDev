<?php
//Content
require_once FW_ROOT."/inc/functions/lb_administration.php";
//Spezialteil
function file_title()
	{
		return "Profil";
	}

	function content_top()
	{
		echo"

		";
	}
//Hauptteil	
function content_main(){ 
	global $db_my;
	global $user;
	global $c;
	if($user->verify(2)===true){
		echo"<div class='content' style='min-height:240px;'>";
		if (find_mobile_browser()===true){
			echo"Bitte nenutzen sie einen Computer";
			exit;
		}
		
		echo"<h2 style='text-align:center;'>Administration</h2>
		
		<a href='".$c->p('edit_settings')."' class='button_theme' style='padding:0px 6px 0px 6px;'> -Einstellungen </a>
		<a href='".$c->p('edit_page')."' class='button_theme' style='padding:0px 6px 0px 6px;'> -Seiten</a>
		<a href='".$c->p('manage_table').$c->get('type','area')."' class='button_theme' style='padding:0px 6px 0px 6px;'> -Bereiche</a>
		<a href='".$c->p('manage_table').$c->get('type','entries')."' class='button_theme' style='padding:0px 6px 0px 6px;'> -Content</a>

		";	
			
		///profil_list_entries
		///Level-1
		echo "<div style='min-height:120px;max-width:100%'>";
		///shows settings entries
		if(!isset($_GET['p'])){
			echo ""; 
		}
		elseif($_GET['p']=="edit_settings"){	
			show_settings_entries($target="edit_settings_form");				
		}
		///shows page entries
		elseif($_GET['p']=="edit_page"){	
			show_pages_list($target="edit_page_form");	
		}
		elseif($_GET['p']=="manage_table"){	
			show_create_table_form($target="create_table_submit",$_GET['type']);
			show_delete_table_form($target="delete_table_submit",$_GET['type']);		
		}
		///show form for edit_page
		elseif($_GET['p']=="edit_page_form" and isset($_GET['id'])){	
			show_page_form();
		}
		///show form for edit_settings
		elseif($_GET['p']=="edit_settings_form" and isset($_GET['id'])){
			echo "<h3 style='text-align:center;'>Einstellungen bearbeiten?</h3>";
			show_edit_settings_form();		
		}
		elseif($_GET['p']=="add_page"){
			echo "<h3 style='text-align:center;'>Neue Seite erstellen?</h3>";
			show_add_page_form($target="add_page_submit");		
		}
		///sends edit_settings
		elseif($_GET['p']=="edit_settings_submit" and $_GET['submit']==1){
			//
			$id = $_POST['id']; 
			$title = $_POST['title'];
			$name = $_POST['name'];
			$value = htmlspecialchars($_POST['value'], ENT_QUOTES);
			//
			if(edit_settings_entry($id,$value)){
				echo"
				<table id='settings' style='width:100%;border-style:solid;border-color:#D3D3D3;border-collapse: collapse;border-width: 1px;'>
				<tr>
					<td style='width:30%;border-style:solid;border-color:#585858;border-width: 1px;'>
						<span id='tooltip'><b>".$_POST['title']."</b><br>'".$_POST['name']."'
					</td>
					<td style='width:70%;border-style:solid;border-color:#585858;border-width: 1px;'>
						".$_POST["value"]."
					</td>
				</tr>
				</table>
				<a href='".$c->p('edit_settings')."' style='width:100%;' class='button'>Weiter</a> 	
				";
			}
		}
		///sends edit_page
		
		elseif($_GET['p']=="create_table_submit" and $_GET['submit']==1){
			//
			$type = $db_my->escape_string($_POST['type']);
			$name = $db_my->escape_string($_POST['name']);
			if(isset($_POST['menu_entry']) and $_POST['menu_entry']==1){
				$menu_entry=true;
			}
			else{
				$menu_entry=false;
			}
			//
			if(create_table($type,$name,$menu_entry)){
				echo "<br>Tabelle erfolgreich erstellt";
			}
			echo"
				<a href='".$c->a('area_manager').$c->get('t',$name)."' class='button' style='width:100%;'>Verwalten</a> 	
				<a href='".$c->a('administration')."' class='button' style='width:100%;'>Weiter</a> 	
				";
		}
		elseif($_GET['p']=="delete_table_submit" and $_GET['submit']==1){
			//
			$type = $db_my->escape_string($_POST['type']);
			$name = $db_my->escape_string($_POST['name']);
			if(isset($_POST['delete']) and $_POST['delete']==1){
				$delete=true;
			}
			else{
				$delete=false;
			}
			//
			if(remove_table($type,$name,$delete)){
				echo"
				<br>Tabelle erfolgreich entfernt ($delete)
				<a href='".$c->a('administration')."' class='button' style='width:100%;'>Weiter</a> 	
				";
			}
		}
		elseif($_GET['p']=="edit_page_submit" and $_GET['submit']==1){
			//
			$id = $_POST['id']; 
			$name = $_POST['name'];
			$content = $_POST['content'];
			//
			if(edit_page($id=$id,$name=$name,$value=$content)){
				echo"
				<table id='settings' style='width:100%;border-style:solid;border-color:#D3D3D3;border-collapse: collapse;border-width: 1px;'>
				<tr>
					<td style='width:30%;border-style:solid;border-color:#585858;border-width: 1px;'>
						<b>".$_POST['name']."
					</td>
					<td style='width:70%;border-style:solid;border-color:#585858;border-width: 1px;'>
						".$_POST["content"]."
					</td>
				</tr>
				</table>
				<a href='".$c->ref('administration','edit_page')."' class='button' style='width:100%;' style='width:100%;'>Weiter</a> 	
				";
			}
		}
		elseif($_GET['p']=="add_page_submit" and $_GET['submit']==1){
			//
			$name = $_POST['name'];
			$content = $_POST['content'];
			add_page($name,$content);
			echo "<a href='".$c->ref('administration','edit_page')."' class='button' style='width:100%;'>Weiter</a> ";
		}
		else{
			echo"Nichts ausgewählt";
		}			
		echo "</div>";
		///	
			
				
		///bottom
		///bottom
		///bottom
		echo "</div>	
		<div class='content'>
		<a href='logout.php?historyback=profil' class='button' style='width:100%;'><h3>Auslogen</h3></a>
		</div>			
		";		
		//title edit javascript
	}
			
	else{
		die("<div class='content'>	<h1>Nicht eingelogt und/oder keine Adminrechte</h1></div>");
		}
}
	

//Content_left
	function content_left()
	{
		echo "
		";
	}
//Content_right
	function content_right1()
	{
		echo "
		
		";
	}
//Startscript (onLoad='')
	function startscript()
	{
	echo "";
	}
?>