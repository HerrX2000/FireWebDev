<?php
//Content
//Spezialteil
	function file_title()
	{
		return "Registrieren";
	}
	function content_top()
	{
		echo"
		";
	}
//Hauptteil	
	function content_main()
	{ 
		global $user;
		if ($user->verify(0)===true) 
			{
			echo"<div class='content'>Du hast bereits ein Account.</div>";
			}
		else{
			include_once FW_ROOT."/inc/functions/recaptcha.php";
		echo"
		<div class='content'>
		<b>Registrieren (wip):</b>
		<form action='register_send.php' method='post'>
		Username:<br>
		<input type='text' size='24' maxlength='50'
		name='username' required><br>

		E-Mail:<br>
		<input type='email' size='24' maxlength='50'
		name='email' required><br>
		
		Passwort:<br>
		<input type='password' size='24' maxlength='50'
		name='passwort' required><br>

		Passwort wiederholen:<br>
		<input type='password' size='24' maxlength='50'
		name='passwort_repeat' required><br>
		<p class='nodisplay'>
		<label for='email2'>Automatische E-Mail Bestätigung :</label>
		<input id='email2' name='email2' size='60' value='' />
		</p>
		<a href='Nutzerbestimmungen.html' class='linkfarbe2'>Nutzerbestimmungen</a> <input type='checkbox' name='AGB' required>
		<br>";
		recaptcha();
		echo "<input type='submit' value='Abschicken'>
		</form>
		</div>
		"
		;
		}
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