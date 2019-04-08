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
		";
		if($user->verify(0)===false)
		{
			if(@$_GET['processed']==1)
			{
				if($user->login()==true){
					global $c;
					echo"<h3>Login: erfolgreich</h3>"."<b>Hallo: ".$_SESSION["username"]." <br>Weiter zu <a href='".$c->a('profil')."'>Mein Profil</a></b>
					 <script type=\"text/javascript\">
					  location.href = \"".$c->a('profil')."\";
					</script>
					";
				}
				else{
					echo "<h3>Login:</h3> Benutzername und/oder Passwort waren falsch";
					login_form();
					echo"<a href='javascript:history.back()' class='button' style='width:100%;'>Zur&uuml;ck</a>"; 
				}	
			}
			else{
				login_form();
			}
		}
		else
		{
			global $c;
			echo"<h3>Bereits eingelogt</h3>
			<b>Weiter zu <a href='".$c->a('profil')."'>Mein Profil</a></b>
			<script type=\"text/javascript\">
			  setTimeout(function () { location.href = \"".$c->a('profil')."\"; }, 3000);
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