<?php
//Content
function file_title(){
		$titel=$_GET['p'];	
		$titel= ucfirst($titel);
		return $titel;
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
		$id=$_GET['p'];
		echo "<div class='content'>";
		$entry = new entry;
		$entry->init($table="pages",$id);
		$entry->show();
		//echo show_entry($table="entry",$id=$id);
		echo "</div>";
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