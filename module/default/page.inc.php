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
	
function content_main(){	
	global $user;
	global $c;
	
	if (isset($_GET['action']) and $_GET['action']=="edit" and $user->verify(1)===true){
			echo "
			<script src=\"".FW_CLIENT_ROOT."inc/editor/tinymce/tinymce.min.js\"></script>
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
			<form name='setting_form' id='setting_form' action='".$c->ref('administration','edit_page_submit').$c->get('submit',1)."' method='post'>
				<input type='hidden' name='id' value='".$_POST['id']."'>	
				<input type='hidden' name='name' value='".$_POST['name']."'>	
				<textarea name='content' class='editor' type='text' maxlength='1000'>".entry($table="pages",$p=$_POST['name'])."</textarea>
			</form>
				
		<br>
		<a href='#' onclick='document.setting_form.submit();' class='button' style='width:100%;'>Senden</a> 
		<a href='".$c->p($_POST['name'])."' class='button' style='width:100%;'>Zurück</a>
		</div>";
		
		}
		else{
			$p=$_GET['p'];
			$table="pages";
			$page = new page();
			if($page->init($table,$p)){
				$page->show();
			}else{
				echo "<div class='content'><h3>Seite exisitiert nicht</h3>";
				if($user->verify(1)===true){
					echo "<a class='button' style='width:100%;' href='".$c->ref('administration', 'add_page').$c->get('name',$_GET['p'])."'>Seite jetzt erstellen</a>";
				}
				echo"</div>";
			}
			if ($user->verify(1)===true){
				echo"
				<div style='text-align:right;'>
				<form action='".$c->ref('page',$page->cur['name']).$c->get('action','edit').$c->get('id',$page->cur['id'])."' method='post'>
				<input type='hidden' name='table' value='".$page->cur['table']."'>
				<input type='hidden' name='id' value='".$page->cur['id']."'>
				<input type='hidden' name='name' value='".$page->cur['name']."'>
				<input type='image' src='".FW_CLIENT_ROOT."images/icons/entry_edit.png' style='width:32px;height:32px;' alt='edit_entry'>
				</form>
				</div>
				";
			}
		
			//dev image slider
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