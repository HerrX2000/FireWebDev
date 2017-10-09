<?php
//Content
function file_title(){
		$titel="Kommentar senden";	
		return $titel;
		}
//Spezialteil
	function content_top()
	{
	}
//Hauptteil	
	function content_main()
	{
		global $user;
		echo"
		<div class='content'>";
		add_comment_mysql($table='bug_report');
		echo "<h3 align='center'>Erfolgreich</h3>";
		echo"</div>";
	}


//Content_left
	function content_left()
	{
		echo "";
	}
//Content_right
	function content_right1()
	{
		echo "";
	}
?>