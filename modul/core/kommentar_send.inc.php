<?php
//Content
function file_title(){
		$titel="Kommentar senden";	
		return $titel;
		}
//Spezialteil
	function content_top()
	{
		echo"
	
		";
	}
//Hauptteil	
	function content_main()
	{
		echo"
		<div class='content'>";
		echo"
		
		<h3 align='center'>Erfolgreich</h3>
		".add_comment_mysql($table='comments')
		;
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