<?php
//Titel
		

function file_title(){
		$titel="Beitrag entfernen";	
		return $titel;
		}
		
//Content

//Spezialteil
	function content_top()
	{
		echo"
		";
	}
//Hauptteil

		
	function content_main(){	
		global $user;
		if($user->verify(1)===true){
			echo "<div class='content'>";
			remove_entry($table=$_POST["table"], $id=$_POST["id"]);
			echo "
			<script src='tinymce/tinymce.min.js'></script>
				<script>tinymce.init({
					selector:'.tinymce',
					height : 400,
				});
			</script>
			
			<h1>Beitrag entfernt!</h1>ID=".$_POST["id"]."
			<div style=\"padding: 4px; border: 2px solid grey; position: relative;\">
			";
			show_entry($table=$_POST["table"], $id=$_POST["id"]);
			echo"
			</div>
			<a href='index.php' class='button'><h3>Zurück</h3></div>  
			</div>";
		}
		else{
			die("403");
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
function onDate_Event()
		{	
			
			$Datum = date(d."-".m."-".y);
			if ($Datum == "21-11-14"){
			echo "<div class='content' style='text-align:center;'><img src='http://www.deutsche-startups.de/wp-content/uploads/2014/04/ds-startup-silber.jpg' alt='Startup' style='height:auto;width:80%;'></div>";
			}
			if ($Datum == "23-12-14" or $Datum == "24-12-14" or $Datum == "25-12-14"){
			echo "<div class='content' style='text-align:center;'><img src='http://www.snail-mail-shop.com/images/product_images/original_images/frohe_weihnachten.jpg' alt='frohe Weihnachten' style='height:auto;width:80%;'></div>";
			}			
		}	
//Startscript (onLoad='')
	function startscript()
	{
	echo "";
	}
?>