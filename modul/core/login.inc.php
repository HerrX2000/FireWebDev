<?php
//Content
function file_title(){
		$titel="Login";	
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
		require_once("inc/functions/fw_users.inc.php");
		echo"
		<div class='content'>
		<br>
		";
		user_login();
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
		echo "";
	}
//Startscript (onLoad='')
	function startscript()
	{
	echo "";
	}
?>