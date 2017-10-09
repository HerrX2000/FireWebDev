<?php
//Content
function file_title(){
		$titel="Login";	
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
		<div class='content'>
		<br>
		";
		if($user->verify(0)===false)
		{
			if(@$_GET['processed']==1)
			{
				if($user->login()==true){
					echo"<h3>Login: erfolgreich</h3>"."<b>Hallo: ".$_SESSION["username"]." <br>Weiter zu <a href='profil.php'>Mein Profil</a></b>
					 <script type=\"text/javascript\">
					  location.href = \"./profil.php\";
					</script>
					";
				}
				else{
					echo "<h3>Login:</h3> Benutzername und/oder Passwort waren falsch".$spam_protection;
					login_form();
					echo"<a href='javascript:history.back()' class='button'>Zur&uuml;ck</a>"; 
				}	
			}
			else{
				login_form();
			}
		}
		else
		{
			echo"<h3>Bereits eingelogt</h3>
			<b>Weiter zu <a href='profil.php'>Mein Profil</a></b>
			<script type=\"text/javascript\">
			  setTimeout(function () { location.href = \"./profil.php\"; }, 1000);
			</script>
			";
			
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