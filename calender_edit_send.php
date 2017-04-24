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

<?php include("inc/functions/php.inc.php");?>
<title><?php show_file_title(); ?></title>
</head>
<body width="100%" style="background-color:#F1F1F1;">

</head>
<body>
<div align="center">
	<h2><a href='index.php'>Termin-Kalender</a></h2> 
	<div style="width:60%;">
	<div class='content'>
	<?php 
		
			ini_set('display_errors', '1');
			error_reporting(E_ERROR | E_WARNING | E_PARSE);
			global $db_link_i;
			//
			if (!$db_link_i) {
			die ('<br>'.'Connect Error: ' . mysqli_connect_errno());
			}
			//
			else{
			mysqli_select_db($db_link_i, $db_name);
			mysqli_query($db_link_i,"SET NAMES 'utf8'");
			//
			$id=$_POST["id"];
			$Event=$_POST["Event"];
			$Datum=$_POST["Datum"];
			$Link=$_POST["Link"];
			$abfrage1="UPDATE calendar Set event = '$Event', date = '$Datum', Link = '$Link'  WHERE id = '$id'";
			//
			$ausgabe1_unfertig=mysqli_query($db_link_i,$abfrage1);
			echo "
			ID: $id
			<br><br>Name:<br>
			$Event
			<br><br>Datum:<br>
			$Datum
			<br><br>Link:<br>
			$Link
			<br>
			";
		}
		?>
		<a href='calendar.php' class='blutton'><h3>Zurück</h3></a> 
	</div>
	</div>
<?php show_note();?>