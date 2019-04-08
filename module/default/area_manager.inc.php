<?php
//Titel

function file_title(){
		return "Bereich: ".$_GET['t'];
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
		global $c;
		global $user;
		if($user->verify(1)===true){
			$table=$_GET['t'];
			echo "<div class='content'>";
			if (isset($_POST['id']) and isset($_GET['edit']) and $_GET['edit']=="true"){
				edit_area_entries($table,$_POST['id']);
			}
			if (isset ($_GET['add']) and $_GET['add']=="true"){
				if(add_area_entry($table=$table)){
					echo"<script type=\"text/javascript\">
					  location.href = \"{$c->a("area_manager")}{$c->get("t","fireweb")}\";
					</script>";
				}
			}
			if (isset($_POST['id']) and isset ($_GET['delete']) and $_GET['delete']=="true"){
				delete_area_entry($table,$_POST['id']);
			}
			show_area_entries($table=$table, $target=null);
			echo"</div>";	
		}
		else{
			die("403");
		}
	}

	

//Content_left

	function content_left()
	{ 

	}
//Content_right
	function content_right()
	{
		echo "
		
		";
	}
//
function onDate_Event()
		{	
	
		}	
	
//Startscript (onLoad='')
	function startscript()
	{
	echo "";
	}
?>