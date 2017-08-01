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
	if ($_GET['exp']==1){
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
		</script>
			<div class='content' >
			<form action='area_edit.php?table=".$_POST["table"]."&id=".$id=$_POST["id"]."&exp=0' method='post'>
			<input type='image' style='color: #c00 !important; text-transform: uppercase;border: 1px solid #970000;padding-left: 2px;padding-right: 2px;float:right;' alt='switch to old editor'>
			<input type='hidden' name='table' value='".$_POST["table"]."'>
			<input type='hidden' name='id' value='".$id=$_POST["id"]."'>
			</form>
		<h1>Bereich bearbeiten</h1>
		<form name='aendern' action='area_edit_send.php?id=".$_POST["id"]."' method='post'>
			Title: <input type='text' name='name' value='".$_POST["name"]."'>
			<br><br>
			<input type='hidden' name='table' value='".$_POST["table"]."'>
			<input type='hidden' name='id' value='".$_POST["id"]."'>
			<div id='content_pure' class='tinymce' style='margin:-7px;padding:4px;border-style:solid;border-width:2px;border-color:grey;'>
		";
		echo show_entry($table=$_POST["table"], $id=$_POST["id"]);
		echo"</div>
		<input type=\"hidden\" id='content_ready' name='content'>
		</form>
		<br>
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
				plugins: [
				'advlist autolink lists link image charmap print preview anchor',
				'searchreplace visualblocks code fullscreen',
				'insertdatetime media table contextmenu paste code'
			  ],
			  toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
				});
		</script>
		";
		
		echo"<div class='content'>
		<form name='change_editor' action='area_edit.php?table=".$_POST["table"]."&id=".$id=$_POST["id"]."&exp=1' method='post'>
			<input type='hidden' name='table' value='".$_POST["table"]."'>
			<input type='hidden' name='id' value='".$id=$_POST["id"]."'>
			</form>
			<a href='#' onclick='document.change_editor.submit();' class='button'
			style='color: #c00 !important; text-transform: uppercase;border: 1px solid #970000;'>
			<h3>switch to inline-editor</h3></a> 
		</div>";
		
		echo"
		<div class='content'>
		<h1>Bereich bearbeiten</h1>
		<form name='aendern' action='area_edit_send.php?id=".$_POST["id"]."' method='post'>
			<input type='hidden' name='table' value='".$_POST["table"]."'>
			<input type='hidden' name='id' value='".$_POST["id"]."'>
			<textarea name='content' class='tinymce'>
		";
		show_entry($table=$_POST["table"], $id=$_POST["id"]);
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
//Startscript (onLoad='')
	function startscript()
	{
	echo "";
	}
?>