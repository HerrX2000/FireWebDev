<?php
//Titel
		

function file_title(){
		$titel="Beitrag ändern";	
		return $titel;
		}
		
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
	if (!isset ($_GET['inline']) or $_GET['inline']!=0){
			echo "
		<script src=\"//cdn.tinymce.com/4/tinymce.min.js\"></script>
			<script>	tinymce.init({
			  selector: 'div.tinymce',
			  inline: true,
			  plugins: [
				'advlist autolink lists link image charmap print preview anchor',
				'searchreplace visualblocks code fullscreen',
				'insertdatetime media table contextmenu paste'
			  ],
			  toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image'
			});
		</script>";
		
		//header and textarea (with hint for other editor)
		echo"<div class='content'>
		
		<form action='entry_edit.php?table=".$_POST["table"]."&id=".$_POST["id"]."&inline=0' method='post'>
			<input type='image' style='color: #c00 !important; text-transform: uppercase;border: 1px solid #970000;padding-left: 2px;padding-right: 2px;float:right;' alt='switch editor'>
			<input type='hidden' name='table' value='".$_POST["table"]."'>
			<input type='hidden' name='id' value='".$_POST["id"]."'>
			</form>
		
		<h1>Beitrag bearbeiten</h1>
		<form name='aendern' action='entry_edit_send.php?id=".$_POST["id"]."' method='post'>
			<input type='hidden' name='table' value='".$_POST["table"]."'>
			<input type='hidden' name='id' value='".$_POST["id"]."'>
			<div id='content_pure' class='tinymce' style='margin:-7px;padding:4px;border-style:solid;border-width:2px;border-color:grey;'>
		";
		echo show_entry($table=$_POST["table"], $_POST["id"]);
		echo"</div>
		<input type=\"hidden\" id='content_ready' name='content'>
		
		</form>";
		//final send and back buttton
		echo"<br>
		<a href='#' onclick=\"document.getElementById('content_ready').value = document.getElementById('content_pure').innerHTML; document.aendern.submit();\" class='button'><h3>Senden</h3></a> 	
		<a href='index.php' class='button'><h3>Zurück</h3></a> 		
		</div>";		
		}
		else{
			echo "
		<script src=\"//cdn.tinymce.com/4/tinymce.min.js\"></script>
			<script>tinymce.init({
				selector:'.tinymce',
				height : 400,
				browser_spellcheck: true,
				plugins: [
				'advlist autolink lists link image charmap print preview hr anchor',
				'searchreplace visualblocks code fullscreen spellchecker',
				'insertdatetime media table contextmenu paste'
			  ],
			  toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
			
			});
		</script>";
		
		echo"<div class='content'>
		<form name='change_editor' action='entry_edit.php?table=".$_POST["table"]."&id=".$id=$_POST["id"]."&inline=1' method='post'>
			<input type='image' style='color: #c00 !important; text-transform: uppercase;border: 1px solid #970000;padding-left: 2px;padding-right: 2px;float:right;' alt='switch to inline- editor'>
			<input type='hidden' name='table' value='".$_POST["table"]."'>
			<input type='hidden' name='id' value='".$_POST["id"]."'>
			</form>";
		
		echo"		
		<h1>Beitrag bearbeiten
		</h1>
		<form name='aendern' action='entry_edit_send.php?id=".$_POST["id"]."' method='post'>
			<input type='hidden' name='table' value='".$_POST["table"]."'>
			<input type='hidden' name='id' value='".$_POST["id"]."'>
			<p spellcheck='true'><textarea name='content' class='tinymce'></p>
		";

		echo show_entry($table=$_POST["table"], $id=$_POST["id"]);
		echo"</textarea>
		
		</form>
		<a href='#' onclick='document.aendern.submit();' class='button'><h3>Senden</h3></a> 
		<a href='index.php' class='button'><h3>Zurück</h3></a> 		
		</div>";
		}
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
function onDate_Event()
		{	
			
			$Datum = date(d."-".m."-".y);
			if ($Datum == "21-11-14"){
			echo "<div class='content' style='text-align:center;'><img src='http://www.deutsche-startups.de/wp-content/uploads/2014/04/ds-startup-silber.jpg' alt='Startup' style='height:auto;width:80%;'></div>";
			}
			if ($Datum == "23-12-14" or $Datum == "24-12-14" or $Datum == "25-12-14"){
			echo "<div class='content' style='text-align:center;'><img src='http://www.snail-mail-shop.com/images/product_images/original_images/frohe_weihnachten.jpg' alt='frohe Weihnachten' style='height:auto;width:80%;'></div>";
			}			
		}	
//Startscript (onLoad='')
	function startscript()
	{
	echo "";
	}
?>