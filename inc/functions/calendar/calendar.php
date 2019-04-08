<?php
error_reporting(E_ALL);
 header('Content-Type: application/javascript; charset=utf-8');?>
/**
* Ist ein Datum gültig
* @param y: Jahr
* @param m: Monat
* @param d: Tag
* @return true = gültig, false = ungültig
*/
function isValidDate(y,m,d)
{
	//--Gibt Datum des letzten Tag des Monats aus--
	var thisDate = new Date(y,m,1);
	//einen Tag weiter schalten
	thisDate.setMonth(thisDate.getMonth()+1);
	//vom ersten Tag des nächsten monats
	//ein Tag abziehen
	thisDate.setTime(thisDate.getTime() - 12*3600*1000);
	
	if (d>thisDate.getDate())
		{return false;}
	else
		{return true;}
}
/**
* ermittelt den letzten Tag des aktuellen Monats
* @return: gibt letzten Tag zurück
*/
function getLastDayOfMonth()
{
	var d = getDateFromMemory();
	//einen Tag weiter schalten
	d.setMonth(d.getMonth()+1);
	//den ersten des Monats setzen
	d.setDate(1);
	//vom ersten Tag des nächsten monats
	//ein Tag abziehen
	d.setTime(d.getTime() - 12*3600*1000);
	return d.getDate();
}
/**
* übernimmt das angeklickte Datum in das Ausgabeelement
* @param n: Kalendertag zum Kombinieren mit Monat und Jahr
*/
function putDate(n)
{
	var d = getDateFromMemory();
	d.setDate(n);
	
	
	var returnValue;
	if (returnModus==0) //Datum zurückgeben
		{
		returnValue = d.getDate()+'.'+(d.getMonth()+1)+'.'+d.getFullYear();
		}
	else{
		returnValue = getEventtext( d.getFullYear(), d.getMonth(), d.getDate());
		if (!returnValue)
			{returnValue = 'kein Event!';}
	}
	returnValue = returnValue.split("~");
	alert(returnValue[0]);
	if (returnValue != 'kein Event!')
	{
	window.open(returnValue[1], '_blank');
	//location.href = returnValue[1];
}
}
/**
* setzt das übergebene Datum in die Speicherzelle
* @param d: datum zum schreiben in die Speicherzelle
*/
function setDateToMemory(d)
{
	document.all.date_memory.innerHTML = d.getFullYear()+','+(d.getMonth()+1)+','+d.getDate();
}
/**
* Gibt das Datum aus der Speicherzelle zurück
* @return: datum in Date format
*/
function getDateFromMemory()
{
	var s = document.all.date_memory.innerHTML;
	var z = s.split(',');
	return new Date(z[0],z[1]-1,z[2]);
}
/**
* schaltet einen Monat Weiter
*/
function nextMonth()
{
	var d = getDateFromMemory();
	var m = d.getMonth()+1;
	var y = d.getFullYear();
	//Falls Jahres wechsel
	if ((m+1)>12)
	{
		m = 0;
		y = y + 1;
	}
	d = new Date(y,m,01);
	setDateToMemory(d);
	loadcalendar();
}
/**
* schaltet einen Monat zurück
*/
function prevMonth()
{
	var d = getDateFromMemory();
	var m = d.getMonth()+1;
	var y = d.getFullYear();
	
	//Falls Jahres1wechsel
	if ((m-1)<1)
	{
		m = 11;
		y = y - 1;
	}
	else
	{
		m = m - 2;
	}
	d = new Date(y,m,01);
	setDateToMemory(d);
	
	loadcalendar();
}
/**
* zum erstmaligen aufrufen des Kalenders
*/
function iniCalendar()
{
	//heutiges Datum setzen
	var d = new Date();
	//aktuelles Datum speichern
	setDateToMemory(d);
	//Calender laden
	loadcalendar();
}
/**
*	Läd die Tabelle mit dem übergebenen Datum (Monat)
*/
function loadcalendar() 
{
	//aktuelles Datum holen (1. des Monats)
	var d = getDateFromMemory();
	//Monat ermitteln aus this_date (zählen beginnt bei 0, daher +1)
	var m = d.getMonth(); 
	//Jahr ermitteln aus this_date (YYYY)
	var y = d.getFullYear();
	//Monat und Jahr eintragen
	document.all.calendar_month.innerHTML = getMonthname(m+1) + ' ' + y;
	//ersten Tag des Monats festlegen
	var firstD = d;
	firstD.setDate(1);
	//Wochentag ermitteln vom 1. des übergebenen Monats (Wochentag aus firstD)
	var dateDay = firstD.getDay(); //So = 0, Mo = 1 ... Sa = 6
	//Sonntag soll den Wert 7 darstellen -> Mo = 1 ... So = 7
	dateDay = (dateDay == 0) ? 7: dateDay;
	//Speicher für aktuelle Zelle
	var entry = '';
	//Speicher für aktuellen Tag
	var zahl = '';
	//heutiges Datum ermitteln
	var hD = new Date();
	//ist event 
	//falls event, dann darf der Rahmen
	//nicht vom isHolyday überschrieben werden
	var bEvent = false;
	
	//Alle Kalender Spalten durchzählen
	for (var i = 1; i <= 42; i++)
	{
		bEvent = false;
		//holen der aktuellen Zelle
		entry = document.getElementById('calendar_entry_'+i);
		//errechnen der Tages Zahl
		zahl = (i+1)-dateDay;
		//datum zusammenschreiben
		var dx = new Date(y,m,zahl);

		//Eintragen der Daten ab ersten Tag im Monat und wenn es ein gültiges Datum ist
		if (i >= dateDay && isValidDate(y,m,zahl))		
		{
			entry.innerHTML = '<a class=calendar_link href=javascript:putDate('+zahl+')>'+zahl+'</a>';
			entry.hidden = false;
			entry.style.visibility='visible';
			entry.style.border = 'solid 1px';
			//wenn Event ist
			if (!getEventtext(y,m,zahl))
				{entry.style.color='000000';}
			else{
				getEventtext_split = getEventtext(y,m,zahl).split("~");
				entry.innerHTML = '<span id="tooltip"><a class=calendar_link_event href=javascript:putDate('+zahl+')>'+zahl+'<span>'+getEventtext_split[0]+'</span></a></span>';
				//Eventtext wird als Tooltip angezeigt
				bEvent = true;
			}

						
			//heutiges Datum hervorheben			
			if (hD.getDate() == dx.getDate() && 
				hD.getMonth() == dx.getMonth() && 
				hD.getYear() == dx.getYear())
			{
				entry.style.border = 'solid 1px';
				entry.style.fontWeight = 'bold';
				entry.style.borderColor="#FF7F24";
			}
			
				
		}
		else
		{
			entry.innerHTML = '';
		
			if (i>= dateDay)
			{//Wenn Kalenderende
				//Zelle = hidden
				entry.hidden = true;
				entry.style.border = '0px';
			}
			else
			{//Wenn Kalenderanfang
				//Border-width = 0px
				entry.style.border = '0px';
			}
		} 				  				
	}		
}

/**
 * Prüft ob an einem bestimmten Tag ein Event stattfindet
 * und gibt dieses als Text zurück.
 * @param int y: Jahr
 * @param int m: Monat
 * @param int d: tag
 * @return Veranstaltungstext, 
 * 		wenn keine veranstaltung = false
 */
function getEventtext(y,m,d)
{
	//convertieren in int-Zahlen
	y = parseInt(y);
	m = parseInt(m);
	d = parseInt(d);
	
	//Monate fangen bei 0 an zuzählen
	m++;
	//definieren der Events
	<?php
			error_reporting(E_ALL);
			ini_set('display_errors', '1');
			$root=dirname(dirname(dirname(dirname(__FILE__))));
			include($root."/global.php");

			//

			//
			$query="SELECT event,date,link from ". $db_my->prefix ."calendar ORDER BY date ASC";

			//
			$ausgabe1_unfertig = $db_my->query($query);
			//
			$menge = $db_my->num_rows($ausgabe1_unfertig)-1;
			echo "var h = new Array(".$menge.");
			";
			$anzahl = -1;
			while ($row = $db_my->fetch_assoc($ausgabe1_unfertig))
			{
			$rows[] = $row ;
			}
			foreach($rows as $row){
			$date = $row["date"];
			$date_aus = date("d.m.Y",strtotime($date));
			$anzahl = $anzahl + 1;
			echo "
			h[".$anzahl."] = \"".$date_aus."|".$row["event"]." ";
			if (!empty($row["info"])){
			echo " info: ";
			}
			echo "~".$row["link"]."\";
			";			
			}			

	?>
var dH;
	var eH;
	for ( var i = 0; i < h.length; i++) {
		//Datum eH[0] von Event eH[1] trennen
		eH = h[i].split("|");
		//Datum trennen > Tag dH[0], Monat dH[1], Jahr dH[2]
		dH = eH[0].split(".");
		
		if (parseInt(dH[0]) == d && parseInt(dH[1]) == m && parseInt(dH[2]) == y) {
			return eH[1];
		}
	}
	return false;
}

/**
* Ist das Angegebene Datum ein Feiertag?
* @param m : Monat
* @param d : Tag
*/
function isHoliday(m,d)
{	
	//Monate fangen bei 0 an zuzählen
	m++;
	//festlegen der Feiertage

	var h = new Array(1);
	
	//Feiertage
	h[0] = "";
	h[1] = "";


	var iD;
	//Alle Daten Testen
	for ( var i = 0; i < h.length; i++) {
		iH = h[i].split(".");
				
		if (iH[0] == d && iH[1] == m) {
			return true;
		}
	}
	//Wenn kein Feiertag gefunden
	return false;
	
}

/**
 * regelt welche Rückgabe erfolgt.
 * 0 = geklicktes Datum wird zurückgegeben.
 * 1 = Veranstaltungstext aus getEventtext() 
 * 		wird zurückgegeben.
 */
var returnModus = 0;

/**
 * Setzt die Art der Rpckgabe bei, Datums-klick
 * @param returnIndex:
 * 		0 = geklicktes Datum zurückgeben
 * 		1 = event aus getEventtext()
 */
function setReturnModus(returnIndex)
	{returnModus = returnIndex;}

/**
* Gibt den Monatsnamen anhand der Monatsnummer zurück
*@param monthnumber: Monatsnummer (1-12)
*/
function getMonthname(monthnumber)
{
	switch(monthnumber)
	{
		case 1:
		  return 'Januar';
		  break;
		case 2:
		  return 'Februar';
		  break;
		case 3:
		  return 'März';
		  break;
		case 4:
		  return 'April';
		  break;
		case 5:
		  return 'Mai';
		  break;
		case 6:
		  return 'Juni';
		  break;
		case 7:
		  return 'Juli';
		  break;
		case 8:
		  return 'August';
		  break;
		case 9:
		  return 'September';
		  break;
		case 10:
		  return 'Oktober';
		  break;
		case 11:
		  return 'November';
		  break;
		case 12:
		  return 'Dezember';
		  break;
		default:
		  return '---';
	}
}