<?php
//Titel
		

function file_title(){
		$titel="Bereicheintrag ändern";	

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
	echo "<div class='content' >
	<script src=\"//cdn.tinymce.com/4/tinymce.min.js\"></script>
	";
	if (!isset ($_GET['inline']) or $_GET['inline']!=0){
		echo "
		
		<script>	tinymce.init({
			  selector: 'div.tinymce',
			  inline: true,
			  plugins: [
				'advlist autolink lists link image charmap print preview anchor',
				'searchreplace visualblocks code fullscreen',
				'insertdatetime media table contextmenu paste'
			  ],
			  toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
			  extended_valid_elements : 'a[href|target|class|onclick]'
			});

		</script>
		";
		$switch_target = "area_edit.php?table=".$_POST["table"]."&id=".$id=$_POST["id"]."&inline=0";
	}
	else{
		echo "
			<script>tinymce.init({
				selector:'div.tinymce',
				height : 400,
				plugins: [
				'advlist autolink lists link image charmap print preview anchor',
				'searchreplace visualblocks code fullscreen',
				'insertdatetime media table contextmenu paste code'
			  ],
			  toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
				});
		</script>
		";
		$switch_target = "area_edit.php?table=".$_POST["table"]."&id=".$id=$_POST["id"]."&inline=1";
	}
	echo"
		<form name='change_editor' action='".$switch_target."' method='post'>
			<input type='image' style='color: #c00 !important; text-transform: uppercase;border: 1px solid #970000;padding-left: 2px;padding-right: 2px;float:right;' alt='switch editor'>
			<input type='hidden' name='table' value='".$_POST["table"]."'>
			<input type='hidden' name='id' value='".$_POST["id"]."'>
			<input type='hidden' name='name' value='".$_POST["name"]."'>
		</form>
		<form name='aendern' action='area_edit_send.php?id=".$_POST["id"]."' method='post'>
		<h1>Bereich bearbeiten</h1>
			Title: <input type='text' name='name' value='".$_POST["name"]."' style='border-style:solid;border-width:2px;border-color:grey;'>
			<br><br>
			<input type='hidden' name='table' value='".$_POST["table"]."'>
			<input type='hidden' name='id' value='".$_POST["id"]."'>
			<div id='content_pure' class='tinymce' style='margin:-2px;padding:1px;border-style:solid;border-width:2px;border-color:grey;'>
		";
		echo show_entry($table=$_POST["table"], $id=$_POST["id"]);
		echo"</div>
		<input type=\"hidden\" id='content_ready' name='content'>
		</form>
		<br>
		<a href='#' onclick=\"document.getElementById('content_ready').value = document.getElementById('content_pure').innerHTML; document.aendern.submit();\" class='button'><h3>Senden</h3></a> 
		<a href='index.php' class='button'><h3>Zurück</h3></a> 		
		</div>
		";
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