<?php

//Content
function file_title(){
		return page_title($default=null);
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
	global $user;
	if (isset($_GET['a']) and $_GET['a']=="edit" and $user->verify(1)===true){
			echo "
			<script src=\"".FW_CLIENT_ROOT."/inc/library/tinymce/tinymce.min.js\"></script>
			<script>tinymce.init({
				selector:'.editor',
				language: '".FW_LANG."',
				height : 320,
				width : '100%',
				min_width: 240,
				max_width: '100%',
				resize: 'both',				
				plugins: [
				'autolink lists link image charmap print preview hr anchor',
				'searchreplace visualblocks code fullscreen spellchecker',
				'insertdatetime media contextmenu paste'
			  ],
			  toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
			
			});
		</script>
		<div class='content'>
			<h1 style='text-align:center;'>Seite bearbeiten</h1>
			<form name='setting_form' id='setting_form' action='administration.php?p=edit_page_submit&submit=1' method='post'>
				<input type='hidden' name='id' value='".$_POST['id']."'>	
				<input type='hidden' name='name' value='".$_POST['name']."'>	
				<textarea name='content' class='editor' type='text' maxlength='1000'>".entry($table="pages",$p=$_POST['name'])."</textarea>
			</form>
				
		<br>
		<a href='#' onclick='document.setting_form.submit();' class='button'>Senden</a> 
		<a href='page.php?p=".$_POST['name']."' class='button'>Zurück</a>
		</div>";
		
		}
		else{
			$p=$_GET['p'];
			$table="pages";
			echo show_page($table,$p);
			echo show_page_edit_button($table,$p);
			
			
			
			
			
			//dev image slider
			if ($_GET['p']=="index"){
				include_once (FW_ROOT."/addon/@praxis_grosse/init.php");
				global $db_my;
				$praxis_grosse = new praxis_grosse();
				$praxis_grosse=$praxis_grosse->image_slider();
			}
			//dev
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