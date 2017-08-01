
<?php
/**
 * FireWeb webbased software series
 * Copyright 2014-2016 Frederik Mann, All Rights Reserved
 *
 * License: http://www.gnu.org/licenses/
 *
 **/

?>
<?php
header("Content-Type: text/html; charset=utf-8");
?>
<?php
//define Page Values
define("FW_PAGE_VERSION", "0.6.9b4");
define("FW_PAGE_API", "7");
//Include

require_once(dirname(__FILE__)."../../../global.php");
?>
<!doctype html>
<html>
<head>

<meta charset="utf-8">
<meta name="description" content="Meta Addon">
<meta name="keywords" content="">
<meta name="robots" content="noindex, follow">

<link rel="stylesheet" type="text/css" href="fw_basic.css">
<!--[if lt IE 7]>
<style type="text/css">@import url(style_simple.css);</style>
<![endif]-->
<?php require ("lb_meta.php"); ?>
<title>Meta Einstellungen</title>
</head>
<body>
<div class="middle" style="min-height:100%;margin-top:-24px;padding-top:4px;padding-bottom:4px;margin-bottom:-12px;">
		<div class="content">
		
		<?php
		$meta= new  meta();	
		
	if(!isset($_GET['p'])){
		$meta->show_meta_list($target="edit_meta_form");			
	}
	///shows meta entries
	elseif($_GET['p']=="edit_meta"){	
		$meta->show_meta_list($target="edit_meta_form");				
		
	}
	///show form for edit_meta
	elseif($_GET['p']=="edit_meta_form" and isset($_GET['id'])){	
		$meta->show_meta_form();
	}
	elseif($_GET['p']=="add_meta"){
		echo "<h3 style='text-align:center;'>Neue Seite erstellen?</h3>";
		$meta->show_add_meta_form($target="add_meta_submit");		
	}
	elseif($_GET['p']=="edit_meta_submit" and $_GET['submit']==1){
		//
		$id = $_POST['id']; 
		$name = $_POST['name'];
		$type = $_POST['type'];
		$meta_description = $_POST['meta_description'];
		$meta_keywords = $_POST['meta_keywords'];
		$meta_robots = $_POST['meta_robots'];
		//
		if($meta->edit_meta($id,$name,$type,$meta_description, $meta_keywords, $meta_robots)){
			echo"
			<table id='settings' style='width:100%;border-style:solid;border-color:#D3D3D3;border-collapse: collapse;border-width: 1px;'>
			<tr>
				<td style='border-style:solid;border-color:#585858;border-width: 1px;'><b>".$_POST['id']."</b></td>
				<td style='border-style:solid;border-color:#585858;border-width: 1px;'><b>".$_POST['name']."</b></td>
				<td style='border-style:solid;border-color:#585858;border-width: 1px;height:54px;'>".$_POST['meta_description']."</td>
				<td style='border-style:solid;border-color:#585858;border-width: 1px;height:54px;'>".$_POST['meta_keywords']."</td>
				<td style='border-style:solid;border-color:#585858;border-width: 1px;height:54px;'>".$_POST['meta_robots']."</td>
			</tr>
			</table>
			<a href='?p=edit_meta' class='button'>Weiter</a> 	
			";
		}
	}
	elseif($_GET['p']=="add_meta_submit" and $_GET['submit']==1){
		//
		$name = $_POST['name'];
		$type = $_POST['type'];
		$meta_description = $_POST['meta_description'];
		$meta_keywords = $_POST['meta_keywords'];
		$meta_robots = $_POST['meta_robots'];
		$meta->add_meta($name,$type,$meta_description, $meta_keywords, $meta_robots);
		echo "<a href='?p=edit_meta' class='button'>Weiter</a> ";
	}
	else{
		echo"Nichts ausgewählt";
	}			
	echo "</div>";
	///	
		
			
	///bottom
	///bottom
	///bottom
	

		?>
		</div>
</div>
<div class="credits" style="padding:0px;">
<a href="http://fireweb.blackburn-division.de/" class="link">Powered by FW´s Read_mode</a>
</div>
<script type="text/javascript" src="inc/js.inc.js"></script>
