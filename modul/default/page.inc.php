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
		$id=$_GET['p'];
		echo show_entry($table="pages",$id=$id);
		//dev image slider
		if ($_GET['p']=="images"){
			echo"<div class='content'>
			<link rel='stylesheet' type='text/css' href='inc/library/diy-slider.css'>

			<div class='diy-slideshow'>";
			function scan_for_images(){
						$dir = FW_ROOT."/images/praxis";
						$dh  = opendir($dir);
						while (false !== ($filename = readdir($dh))) {
							$files[] = $filename;
						}
						$nmb=0;
						foreach($files as $file){
							if (strpos($file,'.jpg') !== false) {
								$file_value = str_replace(".jpg", "", $file);
								if(@$xml_file=simplexml_load_file( FW_ROOT."/images/praxis/".$file_value.".xml")){
									$title = $xml_file->title;
									$text = $xml_file->text;
								}
								else {
									$title = $file_value;
									$text = "";
								}
								if ($nmb!=0){
									$class="";
								}
								else{
									$class="class='show'";
								
								$nmb = 1;
								}
								echo "<figure style='width:100%;' $class>
									<img src='images/praxis/$file' style='width:80%;position:relative;margin-left:10%;z-index:1;' /> 
									<img src='images/praxis/$file' style='width:100%;position: absolute;left: 0%;z-index:0;filter: blur(5px);max-height:495px;' /><figcaption style='padding-left:12%;min-height:2.5em;'><b>".$title."</b></br>".$text."</figcaption> 
								<br>
								</figure>";
								
								
								/*
								echo "<figure style='width:100%;' $class>
									<img src='images/praxis/$file' style='width:100%;' /><figcaption><b>".$title."</b></br>".$text."</figcaption> 
								</figure>";
								simple image no blur
								*/
							}
						}
					}
					scan_for_images();
			echo "
			<span class='prev'>&laquo;</span>
			<span class='next'>&raquo;</span>
			</div>
			</div>
			<script src='inc/library/diy-slider.js'></script>";
		}
		//dev
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