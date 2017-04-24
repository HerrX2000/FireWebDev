<?php
//Titel
		

function file_title(){
		$titel="Send us";	
		return $titel;
		}
		
//Content

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
		echo"
		<div class='content'>
		<div style='text-align:center'>
		<h2>Bug Report</h2>
		Alpha<br></div>";
		echo show_comments($table=$_GET['r'],$limit='60',$spalten='3');
		echo "
		<form name='kommentare' action='./comment_send.php?r=".$_GET['r']."' method='Post'>";
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
			
		echo "
		Öffentlich:<input type='checkbox' name='offentlich' value='1' checked><br>
		<br><textarea name='kommentar' style='width:70%;border-top-left-radius:0px;border-top-right-radius:18px;border-bottom-right-radius:0px;border-bottom-left-radius:18px;' type='text' rows='3' maxlength='300'>";
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
		</div>
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