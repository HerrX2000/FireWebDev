<?php
session_start();
?>
<!doctype html>
<html>

<head>

<meta charset="utf-8">  
<meta name="description" content="FireWeb - ein Projekt einer offenen Website Vorlage.">
<meta name="keywords" content="FireWeb,FireTeam69,69,CMS,HTML,CSS,PHP,Lernen,selfhtml">
<meta name="robots" content="index, follow">
<link rel="icon" href="favicon.ico" type="image/png">
<link rel="stylesheet" type="text/css" href="inc/style/style.css">
<script type="text/javascript" src="inc/calendar.js"></script>
		<link rel="stylesheet" type="text/css" href="inc/functions/calendar/calendar.css" />

<?php include("inc/functions/php.inc.php"); ?>
<title><?php show_file_title(); ?></title>
</head>
<body width="100%" style="background-color:#F1F1F1;">

</head>
<body>
<div align="center">
	<h2><a href='http://blackburn-division.de/'>Termin-Kalender</a></h2> 
	<div style="width:60%;">
	<?php	
		echo "
		<div class='content'><h1>Eintrag bearbeiten?</h1>
		<form name='aendern' action='calender_edit_send.php?Event=".$_POST["Event"]."' method='post'>
			<input type='hidden' name='id' value='".$_POST["id"]."'>
			<br><br>Name:<br>
			<input type='text' name='Event' value='".$_POST["Event"]."'>
			<br><br>Datum:<br>
			<input type='date' name='Datum' value='".$_POST["Datum"]."'>
			<br><br>Link:<br>
			";
			$Link = $_POST["Link"];
			if ($Link != "")
			{
				echo "<input type='text' name='Link' value='".$Link."'>";	
			}
			else
			{
				echo "<input type='text' name='Link' placeholder='Kein Link'>";
			}		
		echo "</form>
		<br>
		<br>
		<a href='#' onclick='document.aendern.submit();' class='button'><h3>Senden</h3></a> 
		<a href='index.php' class='button'><h3>Zurück</h3></a> 	
	</div>";
	?>
<?php show_note();?>