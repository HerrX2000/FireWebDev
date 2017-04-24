<?php
//Titel
		

function file_title(){
		show_area_title($standart='Über uns');
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
	if (find_mobile_browser()==true){bereich_menu_mobile($table='area_about_us',$width='24%',$col='3');}
	echo "<div class='content'>";
	show_area_entry($table='area_about_us',$standart='Über uns');
	echo"</div>";	
	}

	

//Content_left

	function content_left()
	{ 
		echo "<div  class=\"content_left\">";
		show_area_menu($table='area_about_us');
		echo "</div>";
	}
//Content_right
	function content_right1()
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