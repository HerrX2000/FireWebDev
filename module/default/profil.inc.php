<?php
//Content
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
	function content_main()
	{ 
		global $user;
		global $c;
		if ($user->verify(0)===true) 
			{
		if ($user->verify(0)===true){
		$show_profil="inline";
		}
		else{
		$show_profil="none";	
		}
		
		///header
		echo"<div class='content' style='min-height:240px;'>";
		if (find_mobile_browser()===true){
		echo"
		<script src=\"//cdn.ckeditor.com/4.5.4/basic/ckeditor.js\"></script>
			";
		$profil_list_display="display";
		}
		else{
		echo"<script src=\"//cdn.tinymce.com/4/tinymce.min.js\"></script>
			<script>tinymce.init({
				selector:'.editor',
				height : 280,
				width : '99%',
				min_width: 240,
				max_width: 700,
				resize: 'both',				
				plugins: [
				'autolink lists link image charmap print preview hr anchor',
				'searchreplace visualblocks code fullscreen spellchecker',
				'insertdatetime media contextmenu paste'
			  ],
			  toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
			
			});
		</script>
		";
		$profil_list_display="display";
		
		
		}
		
		if(!isset($_GET['p']) or $_GET['p']=="start"){
			$display_menu=true;
		}
		else{
			$display_menu=false;
		}
		
		if($display_menu){
			
			}
			else{
				echo"<a href='".$c->p('start')."'><img src='".FW_CLIENT_ROOT."images/icons/back.png' alt='back' width='32px'></a>";
			}
		
				
		echo "
		<div class='profil_title' style='display: inline-block;'>
			<h2 id=\"profil_title_mobile\" style=\"text-align:center;display:none;\">Mein Profil</h2>
				<h1 id=\"profil_title\" style=\"text-align:center;display:initial;\">Mein Profil</h1>	
		</div>
		<div class='profil_entry' style='min-height:120px;'>
		";
	///function
	///function
	///function
	
		///
		if (isset($_GET['p']) and $_GET['p']!="start"){
			switch ($_GET['p']) {
				case "profil_bearbeiten":
					$profil_title = "Profil bearbeiten";
				echo"
				<form name='edit_profile' action='".$c->a('submitted').$c->get('action','edit_profile')."' method='post'>
				<table style='width:100%;'>
				<br>
				<tr>
					<td>Aktuelles Passwort:</td>
					<td><input type='password' size='20' maxlength='50'name='profil_password' required></td>
				</tr>
				<tr><td><br></td></tr>
				<tr>
					<td>Neues Passwort:</td>
					<td><input type='password' size='20' minlength='5' maxlength='50' name='edit_password'></td>
				</tr>
				<tr>
					<td>	Neues Passwort bestätigen:</td>
					<td>	<input type='password' size='20' minlength='5' maxlength='50' name='edit_password_repeat'> </td>
				</tr>
				</form>
				<tr><td><br></td></tr>
				<tr>
					<td colspan=\"2\"><a href=\"#\" onclick=\"document.edit_profile.submit();\" style=\"width:100%;\" class=\"button\"><b>Senden</b></a></td>
				</tr>
				</table>
				
				"; 
					break;
				case "avatar_upload":
					$profil_title = "Avatar upload";
					echo"<br> <form action=\"addon/@img_upload/init.php\" method=\"post\" enctype=\"multipart/form-data\">
					Select image to upload (max. 64KB/recommend .jpg):
					<br>
					<input type=\"file\" name=\"fileToUpload\" id=\"fileToUpload\">
					<input type=\"submit\" value=\"Upload Image\" name=\"submit\">
					</form>";
					break;
				case "avatar_show":
					$profil_title = "Avatar anzeigen";
					echo" <img src=\"".FW_CLIENT_ROOT."uploads/avatar/".$_SESSION["uid"].".jpg\" alt=\"No Avatar\" height=\"64\" width=\"64\">";
					break;
				case "style_auswählen":
					global $settings;
					function scan_for_style(){
						$dir = FW_ROOT."/inc/style";
						$dh  = opendir($dir);
						while (false !== ($filename = readdir($dh))) {
							$files[] = $filename;
						}
						foreach($files as $file){
							if (strpos($file,'.css') !== false) {
								$file_value = str_replace(".css", "", $file);
								if($xml_file=simplexml_load_file("inc/style/".$file_value.".xml")){
									$name = $xml_file->name;
									$version = $xml_file->version;
								}
								else{
									continue;
								}
								echo "<option value='$file_value'>".$name." - ".$version."</option>";
							}
						}
					}
					$profil_title = "Style auswählen";
					echo"
					<form action='".$c->a('profil')."' method='post'>
					<select name='select_style' class='soflow'>
					<option value='".$settings['default_style']."' selected='selected'>".$settings['default_style']." - Standart</option>
					";
					scan_for_style();
					echo"</select>
					<input type='submit' value='Wechseln'/>
					</form>
					<br><br><br>Manuell:
					<form action='".$c->a('profil')."' method='post'>
					<input name='select_style' type='text' value='style'/>
					<input type='submit' value='Senden'/>
					</form>
					";
					break;
				case "rechte_anzeigen":
					$profil_title = "Rechte anzeigen";
					if (isset($_SESSION["mitglied"])){
						echo "<br>Deine Gruppe: ";
					}
					else{
						echo"Keine Rechte";
					}
					if ($_SESSION["mitglied"]=="0")
					{
						echo "Gast";
					}
					if ($_SESSION["mitglied"]=="1")
					{
						echo "Freund";
					}
					if ($_SESSION["mitglied"]=="2")
					{
						echo "Entwickler";
					}
					if (isset($_SESSION["moderator"]) and $_SESSION["moderator"] == 1) 
					{ 
						echo "<br> Moderator: Ja";	
					}
					if (isset($_SESSION["admin"]) and $_SESSION["admin"] == 1) 
					{ 
						echo "<br> Administrator: Ja";	
					}
					break;
			}
			///			
			///Moderator 
			///
			if ($user->verify(1)===true){
				switch ($_GET['p']) {
					case "area_exp":
						$profil_title = "Area-Manager (experimentell)";
						$array_tables_area=fw_detect_tables($mode="area", 1);
						echo "<table style='width:100%;border-collapse: collapse;'>";
						
						foreach($array_tables_area as $entry){
							echo "<tr style='border-style:solid;border-color:#585858;border-width: 1px;height:54px;'>
							<td style='font-size:2em;'>".$entry[2]."</td>
							<td style='width:42px;'>
							<a href='".$c->a("area_manager").$c->get('t',$entry[2])."' style='padding:2px;'><img alt='edit' src='".FW_CLIENT_ROOT."images/icons/edit.png' style='width:32px;height:32px;'></a>
							</td>
							<td style='width:42px;'>
							<a href='".$c->ref('administration','manage_table').$c->get('type','area')."'><img src='".FW_CLIENT_ROOT."images/icons/remove.png' style='width:32px;height:32px;' alt='add_entry'></a>
							</td>
							";
						}
						echo "<tr>
						<td></td><td></td>
						<td style='border-style:solid;border-color:#585858;border-width: 1px;height:54px;'><a href='".$c->ref('administration','manage_table').$c->get('type','area')."'><img src='".FW_CLIENT_ROOT."images/icons/add.png' style='width:32px;height:32px;' alt='add_entry'></a></td>";
						echo "</tr>";
						echo "</table>";
						break;
					case "news_schreiben":
						$profil_title = "News schreiben";
						echo"&nbsp";
						echo"<form name='news' action='".$c->a('submitted').$c->get('action','entry')."' method='Post'>
						Tabelle: <input type='text' value='news' name='table'>
						<textarea name='editor' class='editor' type='text' maxlength='1000'></textarea>
						</form>
						<a href='#' onclick='document.news.submit();' style='width:100%;' class='button'><b>Senden</b></a>
						";
						break;
					///
					case "event_erstellen":
						$profil_title = "Event erstellen";
						echo"<form name='calendar' action='".$c->a('submitted').$c->get('action','calendar')."' method='Post'>
						<table>
						<tr>
						<td>Name:</td>
						<td><input name='name' type='text' maxlength='30' size='15' required></td>
						</tr>
						
						<tr>
						<td>Datum:</td>
						<td><input name='datum' type='date' value='".date('Y-m-d')."' min='2015-01-01' max='2020-01-01' size='15' required></td>
						</tr>
						<tr>
						<td>Link:</td>
						<td><input name='link' type='text' value='' maxlength='80' size='15'><span id='tooltip'><a href='#' class='link'>[?]<span>In der Form 'link_name.php' für lokales oder 'http://www.domain.de'</span></a></span></td>
						</tr>
						</table>
						<br>
						</form>
						<a href='#' onclick='document.calendar.submit();' style='width:480px;' class='button'>Erstellen</a> 
						";
						break;
				}
			}
			///
			///Admin
			///
			if ($user->verify(2)===true){
				
				switch ($_GET['p']) {
					case "db_exp":
						$profil_title = "Datenbank (experimentell)";
						fw_detect_tables_render(fw_detect_tables(),"width:100%");
						break;
					/*case "kommentare":
						$profil_title = "Kommentare";
						echo"<br><br>";
						show_comments($table='comments',$limit='6',$spalten='2');
						break;*/
					///
					case "bug_report":
						$profil_title = "Bug Report";
						echo"<br><br>";
						show_comments($table='bug_report',$limit='6',$spalten='2');
						break;
					///
					case "website_status":
						$profil_title = "Website Status";
						echo"<br><br>";
						echo"<form name='Status' action='".$c->a('submitted').$c->get('action','status')."' method='post'>
						<select name='status'>
						  <option value='1' selected='selected'>Online</option>
						  <option value='0'>Offline</option>
						</select> HTML-Code
						<br><textarea name='grund' type='text' style='width:100%;' cols='50' rows='10' maxlength='10000'>Grund:<br>Die Website ist zur Zeit wegen Wartungsarbeiten nur f&uuml;r User erreichbar.<br><br>Voraussichtlich
<br>Von: 00:00 Uhr
<br>Bis: 00:00 Uhr</textarea>
						<br>
						</form>
						<a href='#' onclick='document.Status.submit();' style='width:100%;' class='button'>Senden</a>";
						
						break;
				}
			}
		}
		else{
			$profil_title = $_SESSION["username"]."´s Profil";
			/* outdated since 0.7.2 echo"
			 <input type='image' src='images/icons/mobile_menu.png' id='profil_menu_open' alt='Submit' onclick=\"toggle('profil_menu');\"
			 style='float:left;cursor: pointer;margin-top:10px;width:32px;height:32px;'>";*/
			echo"<div class='profil_user_entry'><img src=\"".FW_CLIENT_ROOT."uploads/avatar/".$user->uid().".jpg\" alt='user_icon' width='128px' style='float:left;'>
			<p style='margin-left:128px;margin-right:10%;'>Willkommen  im User-Panel, ".$user->uname().".
			<br><i style='text-align:center;'>-beta-</i>
			</p></div>";	
			///profil_list_entries
			///Level-1
			echo "
			<div class='profil_menu' id='profil_menu' style='display:$profil_list_display;'>
			
			<table id='profil_menu_table' style='width:100%;'>
			<tr>
				<td class='profil_menu_entry'>
					<a onclick=\"toggle_sev('profil');\" class='button' style='height:40px;width:100%;cursor: pointer;outline-style:none;'><img src='".FW_CLIENT_ROOT."images/icons/user.png' alt='profil' height='20em'><b>Profil</b></a>
				</td>
			</tr>
			<tr name='profil' style='display:$show_profil;width:100%;'>
				<td class='profil_menu_entry'>
					<a href='".$c->p('profil_bearbeiten')."' class='button' style='width:100%;height:40px;'>Passwort ändern</a>
				</td>
			</tr>
				
			<tr name='profil' style='display:$show_profil;'>
				<td class='profil_menu_entry'>
					<a href='".$c->p('style_auswählen')."' class='button' style='width:100%;height:40px;color:grey;'>Style auswählen &#10013;</a>
				</td>
			</tr>
			<tr name='profil' style='display:$show_profil;'>
				<td class='profil_menu_entry'>
					<a href='".$c->p('rechte_anzeigen')."' class='button' style='width:100%;height:40px;'>Rechte anzeigen</a>
				</td>
			</tr>
			";
			//Level-2
			if ($user->verify(1)===true){
			echo"
			<tr name='profil' style='display:$show_profil;'>
				<td class='profil_menu_entry'>
						<a href='".$c->p('avatar_upload')."' class='button' style='width:100%;height:40px;'>Avatar ändern</a>
					<!--<a href='".$c->p('avatar_show')."' class='button'>!</a>-->
				</td>
			</tr>
			<tr>
				<td class='profil_menu_entry'>
					<a onclick=\"toggle_sev('moderator');\" class='button' style='height:40px;width:100%;cursor: pointer;outline-style:none;'><img src='".FW_CLIENT_ROOT."images/icons/mod.png' alt='moderator' height='20em'> <b>Moderation</b></a>
				</td>
			</tr>
			<tr name='moderator' style='display:none;'>
				<td class='profil_menu_entry'>
					<a href='".$c->p('area_exp')."' class='button' style='width:100%;height:40px;'>Area-Manager (experimentell)</a>
				</td>
			</tr>
			<tr name='moderator' style='display:none;'>
				<td class='profil_menu_entry'>
					<a href='".$c->p('news_schreiben')."' class='button' style='width:100%;height:40px;color:grey;'>News schreiben &#10013;</a>
				</td>
			</tr>
			<tr name='moderator' style='display:none;'>
				<td class='profil_menu_entry'>
					<a href='".$c->p('event_erstellen')."' class='button' style='width:100%;height:40px;color:grey;'>Event erstellen &#10013;</a>
				</td>
			</tr>
			";}
			//Level-3
			if ($user->verify(2)===true){
			echo"
			<tr>
				<td class='profil_menu_entry'>
					<a onclick=\"toggle_sev('administration');\"  class='button' style='height:40px;width:100%;cursor: pointer;outline-style:none;'><img src='".FW_CLIENT_ROOT."images/icons/admin.png' alt='admin' height='20em'><b>Administration</b></a>
				</td>
			</tr>
			<!--<tr name='administration' style='display:none;'>
				<td class='profil_menu_entry'>
					<a href='".$c->p('kommentare')."' class='button' style='width:100%;height:40px;color:grey;'>Kommentare 	&#10013;</a>
				</td>
			</tr>-->
			<tr name='administration' style='display:none;'>
				<td class='profil_menu_entry'>
					<a href='".$c->p('bug_report')."' class='button' style='width:100%;height:40px;color:grey;'>Bug-Report &#10013;</a>
				</td>
			</tr>
			<tr name='administration' style='display:none;'>
				<td class='profil_menu_entry'>
					<a href='".$c->p('db_exp')."' class='button' style='width:100%;height:40px;'>Datenbank (experimentell)</a>
				</td>
			</tr>
			<tr name='administration' style='display:none;'>
				<td class='profil_menu_entry'>
					<a href='".$c->p('website_status')."' class='button' style='width:100%;height:40px;'>Website-Status</a>
				</td>
			</tr>
			<tr name='administration' style='display:none;'>
				<td class='profil_menu_entry'>
					<a href='".$c->a('administration')."' class='button' style='width:100%;height:40px;'>Admin-Panel</a>
				</td>
			</tr>
			<tr name='administration' style='display:none;'>
				<td class='profil_menu_entry'>
					<a href='".FW_CLIENT_ROOT."inc/statistics.php' class='button' style='width:100%;height:40px;' target='_blank'>Statistiken &#8250;</a>
				</td>
			</tr>
			
			
			";
			}
			if (find_mobile_browser()===true)
				{
				echo"
				<tr>
					<td class='profil_menu_entry'>
					<a class='link' href='calendar.php?p=mobile'><b>Kalender</b><a>
					</td>
				</tr>
					";
				}
			echo"</table>
			

					</div>";
		}
		
		
		
		echo "</div>";
		///	
		
			
	///bottom
	///bottom
	///bottom
				echo "</div>	
		<div class='content'>
				<a href='logout.php?historyback=profil' class='button' style='width:100%;'><h3>Ausloggen</h3></a>
				</div>	
				<script>";
		if(find_mobile_browser()===true){
				echo"
				CKEDITOR.replace( 'editor' );
				CKEDITOR.config.width = '100%';";
			}
				echo"
				</script>				
				";
				
				//title edit javascript
		if (find_mobile_browser()===true and isset($profil_title) and $profil_title != ""){
					echo" <script>
				document.getElementById(\"profil_title_mobile\").innerHTML = \"".$profil_title."<br>\";
				document.getElementById(\"profil_title_mobile\").style.display = \"initial\";
				document.getElementById(\"profil_title\").style.display = \"none\";
				</script>";
				}
		elseif (find_mobile_browser()===false and isset($profil_title) and $profil_title != ""){
					echo" <script>
				document.getElementById(\"profil_title\").innerHTML = \"".$profil_title."<br>\";
				</script>";
		}
				
		}
		
		else{
			echo"
			<div class='content'>	<h1>Nicht eingelogt</h1></div>	
			
			";
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