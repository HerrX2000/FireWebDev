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
		echo "<div class='content'>";		
		if (!function_exists('user_logout')) {
			echo "Functions are not available.<br />\n";
		}		
		user_logout();
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