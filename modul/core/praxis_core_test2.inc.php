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
		echo "<div class='content' style='background-image: url(http://localhost/FireWebReborn/images/klee.png); background-position:20px 50%;'>";
		echo show_entry($table="entry",$id="Start");
		echo "</div>";
		echo show_entries($table="news",$limit="5");

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