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
		$table=$_GET['p'];
		show_entries($table=$table,$limit="100");
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