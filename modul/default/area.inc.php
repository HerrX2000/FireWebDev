<?php
//Titel

function file_title(){
		show_area_title($default='Bereich');
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
		if (find_mobile_browser()==true){bereich_menu_mobile($table=$table,$width='24%',$col='3');}
		echo "<div class='content'>";
		
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