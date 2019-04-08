<?php
function header_script(){
	global $user;
	/*if ($user->verify(1)===true){
		header("X-XSS-Protection: 0");
	}
	else{
		ini_set('expose_php', '0');
	}*/
	header('X-Content-Type-Options: nosniff');
	header('x-ua-compatible: IE=EDGE');
	if(isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] !== "off"){
		ini_set('session.cookie_secure', '1');
	}
	ini_set('session.cookie_httponly', '1');
}
function header_end(){
	session_start();
}
function head_script(){
	
}
function show_status($disabled = ''){
		if($disabled != true){
			global $db_my;
			global $settings;
			//$db_my->query("SET NAMES 'utf8'", $hide_errors=0, $write_query=0);
			$status=$settings['status'];
			
			if($settings['status'] == 0 and isset ($_SESSION["username"])){ 
				echo "<p style='text-align:center;'>Wartungsarbeiten</p>";
			}
			elseif($settings['status'] == 0 and !isset ($_SESSION["username"])){
				$status_reason=$db_my->query("SELECT name, value FROM ". $db_my->prefix ."settings WHERE name LIKE 'status_reason'", $hide_errors=0, $write_query=0);
				$status_reason = $db_my->fetch_assoc($status_reason); 
				echo "<div class='background'></div><div class='content' style='height:300px;overflow-y:auto;margin-top:40px;'><div style='text-align:center;'><h1>Offline</h1></div>";
				echo $status_reason ['value'];
				echo "<h4>Es kann zum Totalausfall der Website kommen</h4>
				";
				echo "</div><div class='content' style='text-align:center;'><h3>Login</h3>
				<form name='login' action='login.php?processed=1' method='post'>
				<input type='text' placeholder='Benutzername' size='24' maxlength='150'
				name='username'><br>
				<input placeholder='Passwort' type='password' size='24' maxlength='50'
				name='password'><br>
				<p class='nodisplay'>
				<label for='email2'>E-Mailbestätigung (leer lassen):</label>
				<input id='email2' name='email2' size='60' value='' />
				</p>
				<input type='submit' style='position: absolute; left: -9999px; width: 1px; height: 1px;'/>
				<br></form>
				<a href='#' onclick='document.login.submit();' class='button' style='width:100%;'>Login</a> 
				<a href='#'  onClick='alert('Nicht verfügbar') class='button' style='width:100%;'>Registrieren</a>
				</div>";
				exit;
			}
		}
	}

	//Titel
function show_header(){
	global $settings;
	global $c;
		$page_name = $settings['page_name'];
		$home_name = $settings['home_name'];
		$home_url = $settings['home_url']; 
		$index_act = $settings['index_act'];
		$index_page = $settings['index_page'];
		if($home_name != "" and $page_name == $home_name){
			echo"<h1 style='margin:8px;'><span style='font-size:x-large;margin-left:10%;'><a href='".$c->ref($index_act,$index_page)."' class='link'><b>".$page_name."</b></a></span></h1>";
		}
		else{
			echo"<p><span style='font-size:x-large;margin-left:10%;'>
			<a href='".$home_url."'>
			<img hreflang='de' src='".FW_CLIENT_ROOT."images/icons/home.png' alt='Home' style='height:22px;width:22px'/></a>
			<a href='index.php' class='link'><b>".$page_name."</b></a></span></p>";
		}
}
	function show_title()
	{
		global $settings;
		$page_name = $settings['page_name'];
		$home_name = $settings['home_name'];
		$home_url = $settings['home_url']; 
		if($home_name != "" and $page_name == $home_name){
			echo"<h1><span style='font-size:x-large;margin-left:10%;'><a href='index.php' class='link'><b>".$page_name."</b></a></span></h1>";
		}
		else{
			echo"<h1><span style='font-size:x-large;margin-left:10%;'>
			<a href='".$home_url."'>
			<img src='".FW_CLIENT_ROOT."images/icons/home.png' alt='Home' style='height:22px;width:22px'/></a>
			<a href='index.php' class='link'><b>".$page_name."</b></a></span></h1>";
		}		
	}
	
	
	function show_menu()
	{
		if (function_exists('show_menu_module')){
			show_menu_module();
		}
		else{
		$area = detect_tables($table="area_");
		$area = str_replace("area_","",$area);
		$entries = detect_tables($table="entries_");
		$entries = str_replace("entries_","",$entries);
		if (find_mobile_browser(false)==true)echo "
		
		<a href='entries.php?p=".$entries [0]."' style='width:33%;height:100%;line-height:78px;font-size:1.1em;' class='button_theme'>News</a>
		<a href='area.php?p=".$area [0]."' style='width:33%;height:100%;line-height:78px;font-size:1.1em;' class='button_theme'>Über uns</a>
		<a href='area.php?p=".$area [0]."&r=Discord' style='width:33%;height:100%;line-height:78px;font-size:1.1em;' class='button_theme'>Support</a>
		<!--<a href='http://fireweb.blackburn-division.de/' style='width:25%;height:100%;line-height:78px;font-size:1.1em;' class='button_theme'>FireWeb</a>-->
";
		else echo "
		<a href='entries.php?p=".$entries [0]."' style='width:20%;height:100%;line-height:78px;font-size:1.1em;' class='button_theme'>News</a>
		<a href='area.php?p=".$area [0]."' style='width:20%;height:100%;line-height:78px;font-size:1.1em;' class='button_theme'>Über uns</a>
		<a href='area.php?p=".$area [0]."&name=Discord' style='width:20%;height:100%;line-height:78px;font-size:1.1em;' class='button_theme'>Support</a>
		<!--<a href='http://fireweb.blackburn-division.de/' style='width:15%;height:100%;line-height:78px;font-size:1.1em;' class='button_theme'>FireWeb</a>-->
		";
		}
	}
	
	function menu_order(){
	global $settings;
	$menu_order=array();
	$menu_items = explode(",", $settings['menu_order']);
	foreach ($menu_items as $menu_item){
		$menu_item = explode("=", $menu_item);
		if(count($menu_item)!=3){
			echo"Fehler in Einstellung Titel Class oder ID nicht definiert";
			return;
		}
		$menu_item_title = $menu_item[0];
		$menu_item_class = $menu_item[1];
		$menu_item_name = $menu_item[2];
		//$menu_item_value=detect_tables($table=$menu_item_class."_");
		//$menu_item_value = str_replace($menu_item_class."_","",$menu_item_value);
		//$menu_item [2]= $menu_item_value[$menu_item_id];
		//returns 'array id' instead of 'class name'
		/////////////////////////////////////////////////////////////
		array_push($menu_order,$menu_item);
		
	}
	return $menu_order;
}
	
	function content_right_calender()
	{
		echo "
		<h5><a class='link' href='".FW_CLIENT_ROOT."calendar.php'>Event-Kalender</a></h5>";
		show_calendar_js();
		echo "<br>";
	}
	
	function content_right_contact()
	{
		global $c;
		echo "
		<a href='".$c->ref('page','Impressum')."' class='button' style='width:100%;'><p><b>Kontakt</b></p></a>
		";
	}
	
	function show_credits()
	{
		global $c;
		echo "<a href=\"".$c->ref('page','Impressum')."\" class=\"link\" style=\"margin-right:10%;\">Impressum</a> 
		<a class=\"link\" style=\"margin-left:10%;\" href=\"".FW_CLIENT_ROOT."changelog.html\">Powered by FireWeb</a>";
	}
	
	function show_note()
	{
		echo "
<!--
FireWeb is a Content Managment System/Framework under development.

Copyright (C) 2014-2018 Frederik Mann

This program is under the GNU General Public License, see <http://www.gnu.org/licenses/>.
		
The source code is available via Github@FireWebDev.

Thanks to the Notepad++ Team!
Thanks to the XAMPP Team!
-->
"
;
	}
//Stand not in use
		function footer_show_modified()
		{
		global $fw_modified;
		echo "Stand: $fw_modified";
		}
//Stand
		function footer_show_version()
		{
			global $user;
			$fw_version= FW_VERSION;
			if ($user->verify(2)!=true){
			$fw_version_warning=false;
			}
			elseif (version_compare(FW_VERSION, FW_CORE_VERSION,  '>')){

			$fw_version_warning = "Core outdated%21%0AFireWeb%3A".FW_VERSION." &#040;".FW_API."&#041; %0ACore%3A".FW_CORE_VERSION." &#040;".FW_CORE_API."&#041; ";
			}
			elseif (version_compare(FW_VERSION, FW_MODULE_VERSION,  '>')){
			$fw_version_warning = "Module outdated%21%0AFireWeb%3A".FW_VERSION." &#040;".FW_API."&#041; %0AModule%3A".FW_MODULE_VERSION." &#040;".FW_MODULE_API."&#041; ";
			}
			elseif (version_compare(FW_VERSION, FW_CORE_VERSION, '=')){
			$fw_version_warning=false;
			}
			else {
				$fw_version="undefined";
			}
			$fw_version_hint="%0A%0AVersion (API)";
			if(FW_VERSION_STATUS!="")
			{
				$fw_version = $fw_version."(".FW_VERSION_STATUS.")";
			}				
			if($fw_version_warning==false){
				echo "Version <a href='".FW_CLIENT_ROOT."changelog.html' class='link_accent'>$fw_version</a>";
			}
			else{
				echo "Version <a class='link' style='color:white;cursor:pointer;' onClick=\"alert(unescape('$fw_version_warning$fw_version_hint'))\">!</a><a href='".FW_CLIENT_ROOT."changelog.html' class='link_accent'>$fw_version</a>";
				
			}
		}		

//Style
	function footer_show_style(){
		if (isset($_COOKIE["style_set"])){
			$style=$_COOKIE["style_set"];
			$style=basename($style,".css");
		}
		else{
			global $settings;
			$style=$settings['default_style'];
		}
		
		if (file_exists ("inc/style/".$style.".xml")){
			$xml_file=simplexml_load_file("inc/style/".$style.".xml");
			if(FW_VERSION == $xml_file->fwversion or FW_API == $xml_file->api ){
				$uptodate="yes";				
			}else{
				$uptodate="no";
			}
			echo "Style: ".	$xml_file->name ."<!-- Style-Version:". $xml_file->version . " for FireWeb:". $xml_file->fwversion . " / API:" . $xml_file->api .  " | up-to-date: $uptodate-->";
		}
		else{
				 echo "Style: ".$style;
		}
	}		
	

//Function w3c
		function footer_show_w3c(){
		global $c;
		$dateiname=$_SERVER['SCRIPT_NAME'];  
		$path = pathinfo($dateiname);
		echo "
		<a style='float:left;' class='link' href='http://validator.w3.org/check?uri=".$c->a($c->cur()['a'])."' target='_blank' rel=\"external noopener noreferrer\">
		<img src='".FW_CLIENT_ROOT."images/icons/html5.png' alt='W3C' width='50'>
		</a> "
		;
		}
//Function Titel	use unknown
	
		function show_head_title(){
		global $settings;
		if (function_exists('file_title'))
		{
		$file_title = file_title();
		}
		else{
		$dateiname=$_SERVER['SCRIPT_NAME'];  
		$path = pathinfo($dateiname);
		$path["filename"]= ucfirst($path["filename"]);
		$file_title = $path["filename"];
		}
		echo $settings['page_name']." - ".$file_title;
		}
		
	
	?>