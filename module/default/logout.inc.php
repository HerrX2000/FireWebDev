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
		$user->logout();
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