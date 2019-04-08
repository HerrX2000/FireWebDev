<?php
//Content
function file_title(){
		$titel="Profil geändert";	
		return $titel;
		}

//Spezialteil
	function content_top()
	{
		echo"
		<br>
		";
	}
//Hauptteil
function content_main()
	{ 	
		global $user;
		echo"<div class='content'>";
		if ($user->verify(0)===true) {
			switch ($_GET["action"]) {
				case "status":
					edit_status();
					break;
				case "calendar":
					add_calendar_entry();
					break;
				case "entry":
					$table="entries_".$_POST['table'];
					add_entry($table);
					break;
				case "edit_profile":
					if($_POST['profil_password']!=""){
						$user->profil_edit();
					}
					break;
			}
		}
		echo"</div>";
	
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