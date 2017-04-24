<?php   
	function login_mybb(){
		$host="rdbms.strato.de";
		$user="U1910303";
		$psw="Diabolo8";
		$db="DB1910303";
		$link_db=mysqli_connect($host, $user, $psw, $db); 

		$username = $_POST["username"]; 
		$password = $_POST["password"]; 
		$spam_protection = $_POST["email2"];
		$_SESSION["loginkey_active"] = $_POST["loginkey_active"];
		$username = $link_db->real_escape_string($username);
		$password = $link_db->real_escape_string($password); 
		$abfrage = "SELECT username, password, salt, loginkey, email, usergroup, additionalgroups, displaygroup FROM mybb_users WHERE username LIKE '$username' LIMIT 1"; 
		
		$ergebnis = mysqli_query($link_db, $abfrage); 
		$row = mysqli_fetch_object($ergebnis);
		if(!isset ($_SESSION["username"]))
		{
		if($_GET['processed']==1)
		{
		if($row->password == md5(md5($row->salt).md5($password)) or $spam_protection != "") 
			{
			//Gruppen
			//Gast
			//Gastspieler
			//Veteran
			//Admin
			//Mitglied
			$gast=1;
			$gastspieler=2;
			$veteran=3;
			$admin=4;
			$mitglied=6;
			//
			$_SESSION["username"] = $username;		
			if($row->email != "")
			{
			$_SESSION["email"] = $row->email;
			}
			echo"erfolgreich</h3>"."<b>Hallo: ".$_SESSION["username"]." <br>Weiter zu <a href='profil.php'>Mein Profil</a></b>"; 
			
			$additionalgroups = explode(",", $row->additionalgroups);
			if($row->usergroup == $admin or in_array($admin, $additionalgroups) or $row->usergroup == $veteran or in_array($veteran, $additionalgroups)) 	
			{
			$_SESSION["moderator"] = "1";
			}
			if($row->usergroup == $admin or in_array($admin, $additionalgroups)) 	
			{
			$_SESSION["admin"] = "1";
			}
			
			if($row->displaygroup == $mitglied) 	
			{
			$_SESSION["mitglied"] = "1";
			}
			if($row->displaygroup == $veteran) 	
			{
			$_SESSION["mitglied"] = "2";
			}
			if($row->displaygroup == $admin) 	
			{
			$_SESSION["mitglied"] = "3";
			}
			$_SESSION["loginkey"] = $row->loginkey;
			unset($_SESSION["password"]);
			}
		else
			{ 
			echo "fehlgeschlagen</h3>Benutzername und/oder Passwort waren falsch.
			".$spam_protection;
		echo"		
		<div style='text-align:center;'><h3>Login</h3>
		<form action='login.php?processed=1' method='post'>
		<input type='text' placeholder='Benutzername' size='24' maxlength='150'
		name='username'><br>
		<input placeholder='Passwort' type='password' size='24' maxlength='50'
		name='password'><br>
		<p class='nodisplay'>
		<label for='email2'>E-Mailbestätigung (leer lassen):</label>
		<input id='email2' name='email2' size='60' value='' />
		</p>
		<br>
		<input type='submit' value=' Login '>
		<br></form></div>
		<br>
		<a href='http://forum.blackburn-division.de/member.php?action=lostpw' class='block2'>Passwort vergessen?</a>
		<a href='http://forum.blackburn-division.de/member.php?action=register' class='block2'>Registrieren</a>
		";	
			
			echo"<a href='javascript:history.back()' class='block2'>Zur&uuml;ck</a>"; 
			}
		
		
		}
		else
		{
			echo"<!--nicht ?processed=1 daher keine Login-->
			Prozess nicht gestartet <div style='text-align:center;'><h3>Login</h3>
		<form action='login.php?processed=1' method='post'>
		<input type='text' placeholder='Benutzername' size='24' maxlength='150'
		name='username'><br>
		<input placeholder='Passwort' type='password' size='24' maxlength='50'
		name='password'><br>
		Merken: <input type='checkbox' value='1' name='loginkey_active' checked='checked'>
		<p class='nodisplay'>
		<label for='email2'>E-Mailbestätigung (leer lassen):</label>
		<input id='email2' name='email2' size='60' value='' />
		</p>
		<br>
		<input type='submit' value=' Login '>
		<br></form></div>
		<br>
		<a href='http://forum.blackburn-division.de/member.php?action=lostpw' class='block2'>Passwort vergessen?</a>
		<a href='http://forum.blackburn-division.de/member.php?action=register' class='block2'>Registrieren</a>
		
			";
		}
		
	}
		else
		{
			echo"Bereits eingelogt</h3>
			<b>Weiter zu <a href='profil.php'>Mein Profil</a></b>
			<script type=\"text/javascript\">
			  setTimeout(function () { location.href = \"./profil.php\"; }, 1000);
			</script>
			";
			
		}
		}
		
	function login_token_mybb($loginkey){
		$host="rdbms.strato.de";
		$user="U1910303";
		$psw="Diabolo8";
		$db="DB1910303";
		$link_db=mysqli_connect($host, $user, $psw, $db); 
		$abfrage = "SELECT username, password, salt, email, usergroup, additionalgroups, displaygroup, loginkey FROM mybb_users WHERE loginkey LIKE '$loginkey' LIMIT 1"; 
		$ergebnis = mysqli_query($link_db, $abfrage); 
		$row = mysqli_fetch_object($ergebnis);
		if(mysqli_num_rows($ergebnis) == 0) { 
			
			echo"		
		<h3>Login</h3>
		<form name='login' action='login.php' method='post'>
		<input type='text' placeholder='Benutzername' size='14' maxlength='150'
		name='username'><br>
		<input placeholder='Passwort' type='password' size='14' maxlength='50'
		name='password'><br>
		<p class='nodisplay'>
		<label for='email2'>E-Mailbestätigung (leer lassen):</label>
		<input id='email2' name='email2' size='60' value='' />
		<input type='submit' style='position: absolute; left: -9999px; width: 1px; height: 1px;'/>
		</p>
		<br></form>
		<a href='#' onclick='document.login.submit();' class='block2'>Login</a> 
		<a href='http://forum.blackburn-division.de/member.php?action=register' class='block2'>Registrieren</a>
		";		
		} 
		elseif(!isset ($_SESSION["username"]))
		{
		if($row->loginkey == $loginkey) 
			{
			//Gruppen
			//Gast
			//Gastspieler
			//Veteran
			//Admin
			//Mitglied
			$gast=1;
			$gastspieler=2;
			$veteran=3;
			$admin=4;
			$mitglied=6;
			//
			$_SESSION["username"] = $row->username;		
			if($row->email != "")
			{
			$_SESSION["email"] = $row->email;
			}
			echo"<br><b>Hallo: ".$_SESSION["username"]."</b><br><br>"; 
			
			$additionalgroups = explode(",", $row->additionalgroups);
			if($row->usergroup == $admin or in_array($admin, $additionalgroups) or $row->usergroup == $veteran or in_array($veteran, $additionalgroups)) 	
			{
			$_SESSION["moderator"] = "1";
			}
			if($row->usergroup == $admin or in_array($admin, $additionalgroups)) 	
			{
			$_SESSION["admin"] = "1";
			}
			
			if($row->displaygroup == $mitglied) 	
			{
			$_SESSION["mitglied"] = "1";
			}
			if($row->displaygroup == $veteran) 	
			{
			$_SESSION["mitglied"] = "2";
			}
			if($row->displaygroup == $admin) 	
			{
			$_SESSION["mitglied"] = "3";
			}
			}
		else
			{ 
			echo "fehlgeschlagen</h3>Benutzername und/oder Passwort waren falsch.
			".$spam_protection;
		echo"		
		<div style='text-align:center;'><h3>Login</h3>
		<form action='login.php' method='post'>
		<input type='text' placeholder='Benutzername' size='24' maxlength='150'
		name='username'><br>
		<input placeholder='Passwort' type='password' size='24' maxlength='50'
		name='password'><br>
		<p class='nodisplay'>
		<label for='email2'>E-Mailbestätigung (leer lassen):</label>
		<input id='email2' name='email2' size='60' value='' />
		</p>
		<br>
		<input type='submit' value=' Login '>
		<br></form></div>
		<br>
		<a href='http://forum.blackburn-division.de/member.php?action=lostpw' class='block2'>Passwort vergessen?</a>
		<a href='http://forum.blackburn-division.de/member.php?action=register' class='block2'>Registrieren</a>
		";	
			
			echo"<a href='javascript:history.back()' class='block2'>Zur&uuml;ck</a>"; 
			}
		
		
		}
		
		else
		{
			echo"Bereits eingelogt</h3>
			<b>Weiter zu <a href='profil.php'>Mein Profil</a></b>
			";
		}
		}	
		
	function member_mybb()
		{
		$host="rdbms.strato.de";
		$user="U1910303";
		$psw="Diabolo8";
		$db="DB1910303";
		$link_db=mysqli_connect($host, $user, $psw, $db); 
		if (!$link_db) {
		echo '<br>'.'Connect Error: ' . mysqli_connect_errno().' (terminierung(übersprungen))';
		}
		
		//Gruppen
		//Gast
		//Gastspieler
		//Veteran
		//Admin
		//Mitglied
		//Maskottchen
		$gast=1;
		$gastspieler=2;
		$veteran=3;
		$admin=4;
		$mitglied=6;
		$maskottchen=11;
		//
		//
		//
		$anzahl = 0;
		//
		$db_abfrage_1 = "SELECT username, usergroup, displaygroup, additionalgroups, uid FROM mybb_users WHERE displaygroup = '$admin' ORDER BY username"; 
		$db_ausgabe_1=mysqli_query($link_db, $db_abfrage_1);
		
		echo "<div align='center' style='font-size: 1.5em;'>
		<table width='80%'>";
		
			
		while ($row1 = mysqli_fetch_assoc($db_ausgabe_1))
			{
			$rows1[] = $row1 ;
			}
			foreach($rows1 as $row1){

			$anzahl = $anzahl + 1;
			
		
			echo "<tr><td><b>".$row1['username']."</b></td>";
			echo "<td>Leitung";
			echo "<tr><td colspan='2'><br></td></tr>";
			}
		$db_abfrage_2 = "SELECT username, usergroup, displaygroup, additionalgroups, uid FROM mybb_users WHERE displaygroup = '$veteran' ORDER BY username"; 
		$db_ausgabe_2 = mysqli_query($link_db, $db_abfrage_2);
		
			
		while ($row2 = mysqli_fetch_assoc($db_ausgabe_2))
			{
			$rows2[] = $row2 ;
			}
			foreach($rows2 as $row2){
			
			$anzahl = $anzahl + 1;
		
			echo "<tr><td><b>".$row2['username']."</b></td>";
			echo "<td>Veteran";
			echo "<tr><td colspan='2'><br></td></tr>";
			}
		$db_abfrage_3 = "SELECT username, usergroup, displaygroup, additionalgroups, uid FROM mybb_users WHERE displaygroup = '$mitglied' ORDER BY username"; 
		$db_ausgabe_3=mysqli_query($link_db, $db_abfrage_3);
	
		while ($row3 = mysqli_fetch_assoc($db_ausgabe_3))
			{
			$rows3[] = $row3 ;
			}
			foreach($rows3 as $row3){
			$anzahl = $anzahl + 1;
			echo "<tr><td><b>".$row3['username']."</b></td>";
			echo "<td>Mitglied";
			echo "<tr><td colspan='2'><br></td></tr>";
			}
			
		$db_abfrage_4 = "SELECT username, usergroup, displaygroup, additionalgroups, uid FROM mybb_users WHERE displaygroup = '$maskottchen' ORDER BY username"; 
		$db_ausgabe_4=mysqli_query($link_db, $db_abfrage_4);
	
		while ($row4 = mysqli_fetch_assoc($db_ausgabe_4))
			{
			$rows4[] = $row4 ;
			}
			foreach($rows4 as $row4){
			$anzahl = $anzahl + 1;
			echo "<tr><td><b>".$row4['username']."</b></td>";
			echo "<td>Maskottchen";
			echo "<tr><td colspan='2'><br></td></tr>";
			}			
			
			
			echo "</table></div>";
			echo "<h3 align='center'>Mitgliederanzahl: ".$anzahl." </h3>";
		}
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		/*
		function member_mybb_old()
		{		
		$host="rdbms.strato.de";
		$user="U1910303";
		$psw="Diabolo8";
		$db="DB1910303";
		$link_db=mysql_connect($host, $user, $psw); 
		if (!$link_db) {
		echo '<br>'.'Connect Error: ' . mysqli_connect_errno().' (terminierung(übersprungen))';
		}
		
		//Gruppen
		//Gast
		//Gastspieler
		//Veteran
		//Admin
		//Mitglied
		//Maskottchen
		$gast=1;
		$gastspieler=2;
		$veteran=3;
		$admin=4;
		$mitglied=6;
		$maskottchen=11;
		//
		//
		//
		
		mysql_select_db($db) or die ("Datenbank konnte nicht ausgewählt werden"); 
		$abfrage = "SELECT username, usergroup, displaygroup, additionalgroups, uid FROM mybb_users ORDER BY uid"; 
		$ausgabe_unfertig=mysql_query($abfrage,$link_db);
		$anzahl = 0;
		
		echo "<div align='center' style='font-size: 1.5em;'>
		<table width='80%'>";
		
			
		while ($row = mysql_fetch_assoc($ausgabe_unfertig))
			{
			$rows[] = $row ;
			}
			foreach($rows as $row){
			if ($row[displaygroup] == $mitglied or $row[displaygroup] == $veteran or $row[displaygroup] == $admin or $row[displaygroup] == $maskottchen)	
			{
			$anzahl = $anzahl + 1;
			}
		
			$additionalgroups = explode(",", $row[additionalgroups]);
			
			if ($row[displaygroup] == $mitglied or $row[displaygroup] == $veteran or $row[displaygroup] == $admin or $row[displaygroup] == $maskottchen)
			{
			echo "<tr><td><b>".$row[username]."</b></td>";
			if($row[displaygroup] == $mitglied)
			{
			echo "<td>Mitglied";
			}
			else if($row[displaygroup] == $admin) 	
			{
			echo "<td>Leitung";
			}
			else if($row[displaygroup] == $veteran) 	
			{
			echo "<td>Veteran";
			}
			else if($row[displaygroup] == $maskottchen) 	
			{
			echo "<td>Maskottchen";
			}
			echo"</tr>";
			echo "<tr><td colspan='2'><br></td></tr>";
			}
			}
			
			
			
			echo "</table></div>";
			echo "<h3 align='center'>Mitgliederanzahl: ".$anzahl." </h3>";
		}
		*/
		
		
?>