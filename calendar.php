<?php
session_start();
?>
<!doctype html>
<html>

<head>
<script src="inc/library/jquery-2.2.0.js"></script>
<script type="text/javascript" src="addon/@kayalshri-tableExport/tableExport.js"></script>
<script type="text/javascript" src="addon/@kayalshri-tableExport/jquery.base64.js"></script>
<script type="text/javascript" src="addon/@kayalshri-tableExport/jspdf/libs/sprintf.js"></script>
<script type="text/javascript" src="addon/@kayalshri-tableExport/jspdf/jspdf.js"></script>
<script type="text/javascript" src="addon/@kayalshri-tableExport/jspdf/libs/base64.js"></script>
<meta charset="utf-8">  

<meta name="robots" content="index, nofollow">
<meta name="viewport" content="width=device-width">
<link rel="icon" href="favicon.ico" type="image/png">
<link rel="stylesheet" type="text/css" href="inc/style/style.css">
	
		<link rel="stylesheet" type="text/css" href="inc/functions/calendar/calendar.css" />

<?php include("inc/functions/lb_calendar.php"); ?>
<title>Calendar</title>
</head>
<body width="100%" style="background-color:#F1F1F1;">

</head>
<body>
<div align="center">
	<h2><a href='index.php'>Termin-Kalender</a></h2> 
	<div style="width:30%;">
	<?php show_calendar_js();?>
	</div>
	<br>
	<a style="cursor: pointer;" onClick ="$('#calender').tableExport({type:'pdf',escape:'false'});">
<img src="addon/@kayalshri-tableExport/icons/pdf.png" height="48px">
</a>
<a style="cursor: pointer;" onClick ="$('#calender').tableExport({type:'excel',escape:'false'});">
<img src="addon/@kayalshri-tableExport/icons/xls.png">
</a>
<a style="cursor: pointer;" onClick ="$('#calender').tableExport({type:'json',escape:'false'});">
<img src="addon/@kayalshri-tableExport/icons/json.png">
</a>
<a style="cursor: pointer;" onClick ="$('#calender').tableExport({type:'xml',escape:'false'});">
<img src="addon/@kayalshri-tableExport/icons/xml.png">
</a>
	
	<?php
	if(@$_GET['p']=="mobile"){
	echo "<div style=\"width:98%;\">";
	}
	else{
		echo "<div style=\"width:64%;\">";
	}
	show_calendar();
	?>
	</div>

<br>
<!--
credits for export goes to kayalshri @ http://ngiriraj.com/pages/htmltable_export/demo.php# 27/04/2015
{type:'json',escape:'false'}
{type:'json',escape:'false',ignoreColumn:'[2,3]'}
{type:'json',escape:'true'}

{type:'xml',escape:'false'}
{type:'sql'}

{type:'csv',escape:'false'}
{type:'txt',escape:'false'}

{type:'excel',escape:'false'}
{type:'doc',escape:'false'}
{type:'powerpoint',escape:'false'}

{type:'png',escape:'false'}
{type:'pdf',pdfFontSize:'7',escape:'false'}
-->
</div>
<?php show_note();?>