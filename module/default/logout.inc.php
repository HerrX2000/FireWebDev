<?php
function file_title(){
		return "Session gelöscht";
		}
//Content
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
		echo "<div class='content'>";		
		if (!$user) {
			echo "Functions are not available.<br />\n";
			exit;
		}		
		if($user->logout()){
			echo"
			<h2>Ihre Sessions wurden gelöscht</h2>
			Neuen Key erhalten
			<br><a class='button' href='javascript:history.back()' style='width:100%;'>Zurück</a>
			";
		}
		echo "</div>"; 
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
		echo "";
	}
//Startscript (onLoad='')
	function startscript()
	{
	echo "";
	}
?>