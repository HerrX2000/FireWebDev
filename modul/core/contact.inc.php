<?php
//Content
//Spezialteil
function file_title(){
		$titel="Kontakt";
		return $titel;
		}
//Hauptteil	
	function content_main()
	{
		echo"
		<div class='content'>
		<h3>Blackburn Division</h3>
		<h4>Kontakt:</h4>
		<b>Clan-Leader</b>
		<br>Name: Katho
		<br>E-Mail: <a href='mailto:info@blackburn-division.de' class='link'>info@blackburn-division.de</a>
		<br><br>Schreibe eine E-Mail oder einen Kommentar, letzters wird langsamer bearbeitet<br>
		<br><h4>Kommentar:</h4>
	";
		echo "
		<form name='kommentare' action='./kommentar_send.php' method='Post'>";
		if (isset ($_SESSION["username"])) 
			{
			echo"
			<p>Name:<input name='name' style='border-top-left-radius:0px;border-top-right-radius:10px;border-bottom-right-radius:0px;border-bottom-left-radius:10px;'  value='".$_SESSION["username"]."' type='text' maxlength='16' size='16' readonly>
			";
			}
		else
			{
		echo"
		Name:<input name='name' style='border-top-left-radius:0px;border-top-right-radius:10px;border-bottom-right-radius:0px;border-bottom-left-radius:10px;' type='text' maxlength='16' size='16'>
		";
		}
		
		if (isset ($_SESSION["email"])) 
			{ 
			echo "E-Mail: <input style='border-top-left-radius:0px;border-top-right-radius:10px;border-bottom-right-radius:0px;border-bottom-left-radius:10px;' type='text' value='".$_SESSION["email"]." ' size='30' readonly>";
			
			}
		else
			{
			echo "Optionale E-Mail:<input name='email' style='border-top-left-radius:0px;border-top-right-radius:10px;border-bottom-right-radius:0px;border-bottom-left-radius:10px;' type='text' maxlength='40' size='40'>";
			}
			
		echo"
		<br><textarea name='kommentar' style='width:55%;border-top-left-radius:0px;border-top-right-radius:18px;border-bottom-right-radius:0px;border-bottom-left-radius:18px;' type='text' rows='3' maxlength='300'>";
		if (isset($_GET["site"]))
		{
		echo "@Admin#Bug_".$_GET["site"]." ";
		}
		echo "</textarea>
		<br>
		<p class='nodisplay'>
		<label for='email2'>EMail bestätigung !!leer lassen!! (bitte aus füllen):</label>
		<input id='email2' name='email2' size='60' value='' />
		</p>
		<input name='kommentar_submit' type='submit' value='Senden'>
		</form>
		</div>";
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