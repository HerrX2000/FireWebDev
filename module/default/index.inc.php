<?php
//Titel
		

function file_title(){
		$titel="Start";	
		if ($titel==""){
		$dateiname=$_SERVER['SCRIPT_NAME'];  
		$path = pathinfo($dateiname);
		$path["filename"]= ucfirst($path["filename"]);
		$titel = $path["filename"];
		}
		return $titel;
		}
		
//Content

//Spezialteil
	function content_top()
	{
		//Load addon @hotnews
		//include_once '/../addon/@hotnews/init.php';

	}
//Hauptteil

	function content_main()
	{	
		echo show_entry($table="pages",$id="index");
	}

//Content_left
	function content_left()
	{
		echo "";
	}
//Content_right
	function content_right()
	{
		echo "
		";
	}
//Startscript (onLoad='')
	function startscript()
	{
	echo "";
	}
?>