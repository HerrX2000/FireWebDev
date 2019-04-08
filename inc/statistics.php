<?php	
$STARTTIME = microtime(true);
session_start();
header("Content-Type: text/html; charset=utf-8");
error_reporting(E_ERROR | E_WARNING | E_PARSE);
?>
<!DOCTYPE html>
<html>
<head>
<title>FireWeb - Statistics</title>
<meta charset="utf-8">
<meta name="robots" content="no-index, follow" />
<meta name="viewport" content="width=device-width">
<link rel="stylesheet" type="text/css" href="style/statistics.css">
</head>
<body style="width:100%;">
<a href="../index.php" name="start"><h1>Statistiken</h1></a>
<a href="#start" class="button" style="position: fixed;top:10px;right:10px;">Go to Start</a>
<?php
if ($_SESSION['admin']==1 or $_SESSION['moderator']==1){
include dirname(dirname((__FILE__)))."/global.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$g_date_start=@$_GET['date_start'];
if (isset($_GET['date_start'])){
	$g_date_end=$_GET['date_end'];
}
else{
	$g_date_end=date('Y-m-d');
}

echo"
	<form action=\"statistics.php\" method=\"GET\">
		<input type=\"hidden\" name=\"search\" value=\"1\">
	Zeitraum: <select name=\"date_start\" >
	<option value=\"\">-</option>
    <option value=\"".date('Y-m-d', strtotime("$g_date_end -1 days"))."\">Tag</option>
    <option value=\"".date('Y-m-d', strtotime("$g_date_end -7 days"))."\">Woche</option>
    <option value=\"".date('Y-m-d', strtotime("$g_date_end -30 days"))."\">Monat</option>
	<option value=\"".date('Y-m-d', strtotime("$g_date_end -90 days"))."\">Quartal</option>
  </select>
		Ende: <input  type=\"date\" style=\"padding:2px;border-radius:4px;\" value=\"".$g_date_end."\" name=\"date_end\" max=\"".date("Y-m-d")."\">
				<!--<input type=\"hidden\" value=\"".@$_GET['time_end']."\" name=\"time_end\">-->
		
		Version: <input type=\"text\" list=\"versions\" id=\"version\" value=\"".@$_GET['version']."\" style=\"padding:5px;border-radius:4px;width:100px;\" name=\"version\" placeholder=\"0.7\" onchange=\"select_others()\">
  <datalist id=\"versions\">
    <option value='0.7.2'>
    <option value='0.7.1'>
    <option value='0.7'>
  </datalist>
		Seite: <input type=\"text\" list=\"pages\" id=\"page\" value=\"".@$_GET['page']."\" style=\"padding:5px;border-radius:4px;\" name=\"page\" placeholder=\"page.php\" onchange=\"select_others()\">
 <datalist id=\"pages\">
    <option value='page.php'>
    <option value='index.php'>
    <option value='area.php'>
  </datalist>
		<input type=\"submit\" value=\"Suchen\">
	</form>
	
	";
///set query start
	//no search
	if (!isset($_GET['search']) or $_GET['search']==0){
		$query="SELECT id,date_time,action,page,version,api,useragent,sessionid,exe_time FROM fw_statistic ORDER BY id DESC";
	}
	//all fields
	elseif ($_GET['search']==1 and $_GET['page'] != "" and $_GET['date_start'] != ""  and $_GET['date_end'] != "" and $_GET['version'] != ""){
		$action = $_GET['page'];
		$version = $_GET['version'];
		$time_start = $_GET['time_start'];
		$time_end = $_GET['time_end'];
		if ($time_start=="")$time_start=" 00:00";
		if ($time_end=="")$time_end=" 23:59";
		$date_start = $_GET['date_start']." ".$time_start.":00";
		$date_end = $_GET['date_end']." ".$time_end.":59";
		echo "Eingabe: $action & $date_start bis $date_end & $version";
		$db_my->real_escape_string($version);
		$db_my->real_escape_string($action);
		$db_my->real_escape_string($date_start);
		$db_my->real_escape_string($date_end);
		$query="SELECT id,date_time,action,page,version,api,useragent,sessionid,exe_time FROM fw_statistic WHERE action = '$action' version = '$version' AND date_time BETWEEN  '$date_start' AND '$date_end' ORDER BY id DESC";
	}
	//no version
	elseif ($_GET['search']==1 and $_GET['page'] != "" and $_GET['date_start'] != ""  and $_GET['date_end'] != ""){
		$action = $_GET['page'];
		$time_start = $_GET['time_start'];
		$time_end = $_GET['time_end'];
		if ($time_start=="")$time_start=" 00:00";
		if ($time_end=="")$time_end=" 23:59";
		$date_start = $_GET['date_start']." ".$time_start.":00";
		$date_end = $_GET['date_end']." ".$time_end.":59";
		echo "Eingabe: $action & $date_start bis $date_end";
		$db_my->real_escape_string($action);
		$db_my->real_escape_string($date_start);
		$db_my->real_escape_string($date_end);
		$query="SELECT id,date_time,action,page,version,api,useragent,sessionid,exe_time FROM fw_statistic WHERE action = '$action' AND date_time BETWEEN  '$date_start' AND '$date_end' ORDER BY id DESC";
	}
	//only page
	elseif ($_GET['search']==1 and $_GET['page'] != ""){
		$action = $_GET['page'];
		echo "Eingabe: ".$action;
		$db_my->escape_string($action);
		$query="SELECT id,date_time,action,page,version,useragent,sessionid,exe_time FROM fw_statistic WHERE action = '$action'  ORDER BY id DESC";
	}
	//only date
	elseif ($_GET['search']==1 and $_GET['date_start'] != ""  and $_GET['date_end'] != ""){
		$time_start = $_GET['time_start'];
		$time_end = $_GET['time_end'];
		if ($time_start=="")$time_start=" 00:00";
		if ($time_end=="")$time_end=" 23:59";
		$date_start = $_GET['date_start']." ".$time_start.":00";
		$date_end = $_GET['date_end']." ".$time_end.":59";
		echo "Eingabe: $date_start bis $date_end";
		$db_my->escape_string($date_start);
		$db_my->escape_string($date_end);
		$query="SELECT id,date_time,action,page,api,version,useragent,sessionid,exe_time FROM fw_statistic WHERE date_time BETWEEN '$date_start' AND '$date_end' ORDER BY id DESC";
	}
	//only version
	elseif ($_GET['search']==1  and $_GET['version'] != ""){
		$version = $_GET['version'];
		echo "Eingabe: $version";
		$db_my->escape_string($version);
		$query="SELECT id,date_time,action,page,version,api,useragent,sessionid,exe_time FROM fw_statistic WHERE version = '$version' ORDER BY id DESC";
	}
	//in case
	else{
		$query="SELECT `id`,`date_time`,`action`,`api`,`version`,`useragent`,`sessionid`,`exe_time` FROM fw_statistic ORDER BY id DESC";
	}
//set query end
//set data
$fetch = $db_my->query($query);
$total = $fetch->num_rows;
$average = null;
$api = null;
$incapis = array();
$averagepc = null;
$totalpc = null;
$averagemobile = null;
$totalmobile = null;
$incversions = array();
$incsessionids = array();
include_once FW_ROOT."/inc/functions/detect_browser.php";
include_once FW_ROOT."/inc/functions/median.php";
if ($total==0)exit("<br><br>No results");
//determ data
while ($row = mysqli_fetch_assoc($fetch))
			{
			$rows[] = $row;
			}
$median=array();
	//median and average
		foreach($rows as $row){
			if ($row['exe_time']>=999){
				$row['exe_time']=999;
				}
			if ($row['id']==1){
				$start_datetime_query = $row['date_time'];
				}
			if (in_array($row['version'],$incversions) == false){
				array_push($incversions , $row['version']);
			}
			if (in_array($row['api'],$incapis) == false){
				array_push($incapis, $row['api']);
			}
			if (in_array($row['sessionid'],$incsessionids) == false){
				array_push($incsessionids, $row['sessionid']);
			}
			
			$average=$average+$row['exe_time'];
			array_push($median,$row['exe_time']);
			if ($row['api'] != null){
			$api=$api+$row['api'];
			$prev_api = $row['api'];
			}
			else{
			$api=$api+$prev_api;
			}
			if(preg_match('/(iphone|ipad|ipod|android|mobile|smartphone|blackberry|iemobile|kindle|opera mobi|opera mini)/i', $row['useragent'])) {
			$averagemobile=$averagemobile+$row['exe_time'];
			$totalmobile = $totalmobile+1;
			}
				
			elseif($row['useragent']!=""){
			$averagepc=$averagepc+$row['exe_time'];
			$totalpc = $totalpc+1;
			}
		}
			$end_datetime_query = $row['date_time'];
		//set data
			if ($total ==0) $total = 1;
			if ($totalpc ==0) $totalpc = 1;
			if ($totalmobile ==0) $totalmobile = 1;
			$perc = $median;
			$median = array_median($median);
			$perc = array_perc($perc, 0.9);
			$averageapi = $api / $total;
			$average = $average / $total;
			$averagepc = $averagepc / $totalpc;
			$averagemobile = $averagemobile / $totalmobile;
			$average = round($average,1);
			$averagepc = round($averagepc,1);
			$averagemobile = round($averagemobile,1);
			$averageapi = round($averageapi,4);
		//echo result
		echo"<p>
		<!-- Query: $query <br> -->
			
			Von: $start_datetime_query Bis: $end_datetime_query <br>
			Median Total= $median ms<br>
			90% Total = $perc ms experimentell<br>
			<br>			
			Durchschnitt Total= $average ms<br>
			Durchschnitt PC= $averagepc  ms<br>
			Durchschnitt Mobile= $averagemobile  ms<br>
			Durchschnitt API= $averageapi<br>
			<br>
			APIs=";
			$count=0;
			foreach($incapis as $incapi) {
				if ($incapi != ""){
					if ($count!=0){
					echo "/";
					}
				echo $incapi;
				}
				$count++;
				}
			echo"<br>
			Versions=";
			$count=0;
			foreach($incversions as $incversion) {
				if ($incversion != "" and $incversion !="FW_PAGE_VERSION"){
					if ($count!=0){
					echo "/";
					}
				echo $incversion;
				$count++;
				}
			}
			echo "<br><br>min ";
			$countsession=0;
			foreach($incsessionids as $incsessionid) {
				if ($incsessionid != ""){
				$countsession++;
				}
			}
			echo $countsession;
		echo " Sessions";
		echo "<br>
			$total Aufrufe, davon $totalmobile Mobile und $totalpc Desktop
			</p>
			
		";
		
		echo"
		<a href='#end' class='button' style='float:right;'>Go to End</a>
		<div style=''>
		<script src=\"".FW_CLIENT_ROOT."library/sorttable.js\"></script>
		<table style='width:92%;' class='sortable'>
		<tr>
		<td style='cursor:pointer;font-weight: bold;'>id</td>
		<td style='cursor:pointer;font-weight: bold;'>date time</td>
		<td style='cursor:pointer;font-weight: bold;'>action</td>
		<td style='cursor:pointer;font-weight: bold;'>page</td>
		<td style='cursor:pointer;font-weight: bold;'>version</td>
		<td style='cursor:pointer;font-weight: bold;'>useragent</td>
		<td style='cursor:pointer;font-weight: bold;'>sessionID</td>
		<td style='cursor:pointer;font-weight: bold;'>time</td>
		</tr>";
		foreach($rows as $row){
			$browsers = array("MSIE", "Android", "Chrome");
			if ($row['exe_time']>=9999){$row['exe_time']=9999;}
			echo "<tr>
			<td><a name='".$row['id']."'></a>".$row['id']."</td>
			<td>".$row['date_time']."</td>
			<td>".$row['action']."</td>
			<td>".$row['page']."</td>
			<td>".$row['version']."</td>
			<td>";

// now try it
		$browser = getBrowser($row['useragent'], true);
			echo $browser['platform'].": ".$browser['name']." ".$browser['version'];
			echo"</td>
			<td>".$row['sessionid']."</td>
			<td>".$row['exe_time']."</td>
			</tr>";
			}
echo"</table></div>";			
		
//archive
if 	($_POST['clear']==1 and $_GET['clear']==1 and $_SESSION['admin']==1){
	$api = round($averageapi, 5);
	$query="
	INSERT INTO fw_statistic_archive (id, date_time_start, date_time_end, total, total_pc, total_mobile,
	avg_time, avg_time_pc, avg_time_mobile, avg_api, median)
	VALUES (null, '$start_datetime_query', '$end_datetime_query', '$total', '$totalpc', '$totalmobile',
	'$average', '$averagepc', '$averagemobile', '$api', '$median')
	";
	echo "<br>$query<br>";
	$result = $db_my->query($query);
	if ($result){
	$query="
	TRUNCATE table fw_statistic
	";
	$result = $db_my->query($query);
	echo"Table archiviert
	<script type=\"text/javascript\">
			  setTimeout(function () { location.href = \"./statistics.php\"; }, 2000);
			</script>
	";
	}
	else echo $query."!Fehler";
}
echo "
	<form action=\"statistics.php?clear=1\" method=\"post\" onsubmit=\"return confirm('Sicher das Sie die Statistiken saubern wollen?');\">
	<input type=\"hidden\" name=\"clear\" value=\"1\">
	<input type=\"submit\" value=\"Statistik archivieren\">
	</form>
";

}
else
{
	echo"Keine Zugriffsrechte";
}

?>
<a name="end"></a>
<?php
$ENDTIME = microtime(true);
$RUNTIME = $ENDTIME - $STARTTIME;
$RUNTIME = round ($RUNTIME, 3);
$RUNTIME_MS = $RUNTIME * 1000;
$USERAGENT = $_SERVER['HTTP_USER_AGENT'];
$SCRIPT_NAME = basename($_SERVER['SCRIPT_NAME']);
$SCRIPT_page = dirname($_SERVER['SCRIPT_NAME']);
print "
<!--
Seitenaufbaudauer: $RUNTIME sek / $RUNTIME_MS ms
Useragent: $USERAGENT
Page: $SCRIPT_NAME
page: $SCRIPT_page
Querys: {$query_count}
-->";
?>
<!--FireWeb is a Website under development.

Copyright (C) 2014-2015 Frederik Mann

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program; if not, see <http://www.gnu.org/licenses/>.
		
The source code is currently not available to download. To get the sourcecode contact me.

Thanks to the Notepad++ Team!-->