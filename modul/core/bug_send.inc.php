<?php
//Content
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
	
//Startscript (onLoad='')
	function startscript()
	{
	echo "";
	}	
?>