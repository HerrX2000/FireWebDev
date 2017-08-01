<?php
//Titel

function file_title($case="title"){
		switch ($case){
			case "title": return area_title('Bereich', true);
			break;
			
			case "head": return area_title('Bereich', false);
			break;
			
			default:return area_title($default='Bereich');
		}
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
		$table=$_GET['p'];
		echo "<div class='mobile'>";
		show_area_menu_mobile($table);
		echo "</div>
		<div class='content'>";
		
		show_area_entry($table=$table);
		echo"</div>";	
	}

	

//Content_left

	function content_left()
	{ 
		echo "<div  class=\"content_left\">";
		if (isset($_GET['p'])){
			$table=$_GET['p'];
			show_area_menu($table=$table);
		}
		else{
			echo "Bereich nicht gefunden";
			exit;
		}
		
		
		echo "</div>";
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