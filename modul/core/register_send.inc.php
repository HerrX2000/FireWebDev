<?php
//Content
//Spezialteil
	function set_file()
	{
		return "Registrieren";
	}
//Hauptteil	
	function content_main()
	{
		echo"<div class='content'>";
	require_once("inc/functions/fw_users.inc.php");
	require_once("inc/functions/recaptcha.php");
	if($settings ['recaptcha'] == 1){	
		$captcha=$_POST['g-recaptcha-response'];
		$captcha_key = "6LfriyETAAAAANtFYJv4YbCLioar21yvIuqjpC8d";
		$response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$captcha_key&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR']);
		$obj = json_decode($response);
		if($obj->success == true)
		{
			user_register();
		}
		else
		{
			echo"Fehler bei Sicherheitsprüfung";//error handling
		}
	}
	else{
		user_register();
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
		echo "";
	}
//Startscript (onLoad='')
	function startscript()
	{
	echo "";
	}
?>