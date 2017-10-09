<?php 
//calendar
function show_calendar()
		{
			//
			global $db_my;
			// 
			//$db_my->query("SET NAMES 'utf8'", $hide_errors=0, $write_query=0);
			//
			$query="SELECT id,event,date,link from ". $db_my->prefix ."calendar ORDER BY date DESC";

			//
			$result=$db_my->query($query, $hide_errors=0, $write_query=0);			
			//
			
			echo "<table id='calender' style='width:100%;border-style:solid;border-color:grey;border-width: 1px;'>";
				
			while ($row = $db_my->fetch_assoc($result))
			{
			$rows[] = $row ;
			}
			foreach($rows as $row){
			echo "<tr>";
			$date = $row['date'];
			//Link doesn´t not exist rn
			$row['Link'] = "";
			$date_aus = date("d.m.y",strtotime($date));
			echo "<td style='border-style:solid;border-color:#585858;border-width: 1px;'><b>".$date_aus."</b></td>";
			echo "<td style='border-style:solid;border-color:#585858;border-width: 1px;height:54px;'><b><a href='".$row['Link']."' class='link_accent'>".$row['event']."</a></b></td>";
			global $user;
			if ($user->verify(0)===true){
			echo "<td style='border-style:solid;border-color:#585858;border-width: 1px;width:33px;'>
			<form name='aendern_start' action='calender_edit.php?event=".$row["event"]."' method='post'>
			<input type='hidden' name='id' value='".$row['id']."'>
			<input type='hidden' name='Event' value='".$row["event"]."'>
			<input type='hidden' name='Datum' value='".$row["date"]."'>
			<input type='hidden' name='Link' value='".$row["Link"]."'>	
			<input type='image' src='images/icons/edit.png' style='wdith:32px;height:32px;' alt='edit_event'>			
			</form>
			</a></b></td>";
			}
			echo "</tr>";			
			}			
			echo"</table>";
		}
function show_calendar_js(){
		echo"
		
		<script type='text/javascript' src='inc/functions/calendar/calendar.php'></script>
		
		<table style='margin-left:-2px;width:102.5%;border:2px solid gray; text-align: center;font-size: 12px;background-color:rgba(176,176,176, 0.3) ; ' id='calendar'>
		<tr style='visibility:collapse;' hidden>
			<td colspan=7 id='date_memory'>---</td>
		</tr>
		<tr>
			<td class='calendar_head'><a class='kalender_block'
				href='javascript:prevMonth()'> &laquo;</a></td>
			<td colspan=5 class='calendar_head_month' id='calendar_month'>
				---</td>
			<td class='calendar_head'><a class='kalender_block'
				href='javascript:nextMonth()'> &raquo;</a></td>
		</tr>
		<tr>
			<td class='calendar_day'>Mo</td>
			<td class='calendar_day'>Di</td>
			<td class='calendar_day'>Mi</td>
			<td class='calendar_day'>Do</td>
			<td class='calendar_day'>Fr</td>
			<td class='calendar_day'>Sa</td>
			<td class='calendar_day'>So</td>
		</tr>
		<tr><td id='calendar_entry_1'></td><td  id='calendar_entry_2'></td><td  id='calendar_entry_3'></td><td  id='calendar_entry_4'></td><td  id='calendar_entry_5'></td><td  id='calendar_entry_6'></td><td  id='calendar_entry_7'></td></tr>
		<tr><td  id='calendar_entry_8'></td><td  id='calendar_entry_9'></td><td  id='calendar_entry_10'></td><td  id='calendar_entry_11'></td><td  id='calendar_entry_12'></td><td  id='calendar_entry_13'></td><td  id='calendar_entry_14'></td></tr>
		<tr><td  id='calendar_entry_15'></td><td  id='calendar_entry_16'></td><td  id='calendar_entry_17'></td><td  id='calendar_entry_18'></td><td  id='calendar_entry_19'></td><td  id='calendar_entry_20'></td><td  id='calendar_entry_21'></td></tr>
		<tr><td  id='calendar_entry_22'></td><td  id='calendar_entry_23'></td><td  id='calendar_entry_24'></td><td  id='calendar_entry_25'></td><td  id='calendar_entry_26'></td><td  id='calendar_entry_27'></td><td  id='calendar_entry_28'></td></tr>
		<tr><td  id='calendar_entry_29'></td><td  id='calendar_entry_30'></td><td  id='calendar_entry_31'></td><td  id='calendar_entry_32'></td><td  id='calendar_entry_33'></td><td  id='calendar_entry_34'></td><td  id='calendar_entry_35'></td></tr>
		<tr><td  id='calendar_entry_36'></td><td  id='calendar_entry_37'></td><td  id='calendar_entry_38'></td><td  id='calendar_entry_39'></td><td  id='calendar_entry_40'></td><td  id='calendar_entry_41'></td><td  id='calendar_entry_42'></td></tr>
	</table>
<script type='text/javascript'>iniCalendar();setReturnModus(1);</script>
";
}
function add_calendar_entry()
		{	
			global $db_my;
			$name=$_POST["name"];
			$datum = $_POST["datum"];
			$link = $_POST["link"];
			
			if (!empty($_POST["link"]))
			{
			$link=$link;
			}
			$info=$_POST["info"];			
			
			//
			$spam_protection = $_POST["email2"];			
			//
			if (isset($name) and $name!="")
			{
			$link = $db_my->escape_string($link);
			$name = $db_my->escape_string($name);
			$datum = $db_my->escape_string($datum);
			$info = $db_my->escape_string($info);
			if ($spam_protection != '') {
			die ('Error');
			}
			////
			$result=$db_my->query("SELECT id FROM ". $db_my->prefix ."calendar WHERE date LIKE '$datum'", $hide_errors=0, $write_query=0);
			$menge = $db_my->num_rows($result); 
			if($menge == 0)
			{
			$query="insert into ". $db_my->prefix ."calendar values (NULL,'".$name."','".$datum."','".$link."')";
			$result=$db_my->query($query, $hide_errors=0, $write_query=0);	
			echo "<br><h2>Event erstellt!</h2>";
			}	
			else
			{
			echo "Fehler: exestiert bereits";
			}
		}
		else{
		}
		}
//		
function show_calendar_event_next(){
			global $db_my; 
			global $user;
		//$db_my->query("SET NAMES 'utf8'", $hide_errors=0, $write_query=0);
			$date = date('Y-m-d');
			//
			$query="SELECT event,date from ". $db_my->prefix ."calendar WHERE date >= '$date' ORDER BY date ASC LIMIT 1";
			//
			$result=$db_my->query($query, $hide_errors=0, $write_query=0);
			//
			if ($db_my->num_rows($result) == 0) {
			echo "<p style='text-align:center;'><b>Nächstes Event: </b></p>";
			if ($user->verify(1)===true){
				echo "
				<p style='margin-left:2%;'>-Kein Event geplant-</p>
				<a href='profil.php?p=event_erstellen' class='button'>
				Erstelle Event</a>";
			}
			else{
				echo"<p style='margin-left:2%;'>-Kein Event geplant-</p>";
			}
			}
			else{
			//
			while ($row = $db_my->fetch_assoc($result))
			{
			$rows[] = $row ;
			}
			foreach($rows as $row){
			$datum = $row['date'];
			$datum_aus = date("d.m.y",strtotime($datum));
			if ($datum_aus == date("d.m.y"))
			{
			echo "<p style='text-align:center;'><b>Heute ist der Event: </b></p>";
			echo "<p style='margin-left:2%;'>".$row['event']."</p>";	
			}
			else
			{
			echo "<p style='text-align:center;'><b>Nächstes Event: </b></p>";
			echo "<p style='margin-left:2%;'>".$datum_aus.": <br>";
			echo "".$row['event']."</p>";			
			}
			}
		}
	}
	
//calendar end
?>