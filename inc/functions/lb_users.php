<?php
error_reporting(E_ALL);
$path=(dirname(dirname(dirname(__FILE__))));
include_once ($path."/global.php");
///LOGIN
class user{
	function login() {
		global $db_my;
		$db = $db_my;
		
		if(!isset ($_SESSION["username"]))
		{
		if (!empty($_POST) ) {
		$username = $_POST["username"]; 
		$password = $_POST["password"]; 
		$spam_protection = $_POST["email2"];
		$_SESSION["loginkey_active"] = $_POST["loginkey_active"];
		$username = $db->escape_string($username);
		$password = $db->escape_string($password); 
		$query = "SELECT id,username,password,algo,salt,loginkey,email,usergroup,admin,moderator FROM ". $db_my->prefix ."users WHERE username LIKE '$username' LIMIT 1"; 
		$ergebnis = $db->query($query);	
		$row = $db->fetch_object($ergebnis); 	
		}
		if(@$_GET['processed']==1)
		{
			function hash_algo($hash, $password, $algo, $salt){
				if ($algo=="bcrypt"){
					if (password_verify($password, $hash)) {
						return true;
					}
				}
				elseif ($algo=="md5"){
					if ($hash == hash($algo, md5($salt).md5($password))){
						return true;
					}
				}
				elseif ($algo=="none"){
					if ($hash == $password){
						return true;
					}
				}
			}
			if(mysqli_num_rows($ergebnis) != 0 and hash_algo($row->password, $password, $row->algo, $row->salt) === true and $spam_protection == "") 
				{
				//Gruppen
				//Gast
				//Gastspieler
				//Veteran
				//Admin
				//Mitglied
				$guest=0;
				$friend=1;
				$developer=2;
				$admin=1;
				$moderator=1;
				//
				$_SESSION["uid"] = $row->id;	
				$_SESSION["username"] = $row->username;		
				if($row->email != "")
				{
				$_SESSION["email"] = $row->email;
				}
				if($row->moderator == 1) 	
				{
				$_SESSION["moderator"] = "1";
				}
				if($row->admin == 1) 	
				{
				$_SESSION["admin"] = "1";
				}
				
				if($row->usergroup != "") 	
				{
				$_SESSION["mitglied"] = $row->usergroup;
				}
				if ($row->loginkey!=null){
				$_SESSION["loginkey"] = $row->loginkey;
				}
				unset($_SESSION["password"]);
				
				echo"<h3>Login: erfolgreich</h3>"."<b>Hallo: ".$_SESSION["username"]." <br>Weiter zu <a href='profil.php'>Mein Profil</a></b>
				 <script type=\"text/javascript\">
				  location.href = \"./profil.php\";
				</script>
				";
				
				}
			else
				{ 
				echo "<h3>Login:</h3> Benutzername und/oder Passwort waren falsch".$spam_protection;
				login_form();
				
				echo"<a href='javascript:history.back()' class='button'>Zur&uuml;ck</a>"; 
				}
		}
		else
		{
			login_form();
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

	
	function register(){
		$agb = $_POST["AGB"]; 
		$username = $_POST["username"]; 
		$password = $_POST["passwort"]; 
		$password_repeat = $_POST["passwort_repeat"];
		$email = $_POST["email"];
		$spam_protection = $_POST["email2"];	
			
		if (strpos($username,"'") !== false	or strpos($username,"\\") !== false	or strpos($username,"\"") !== false) {
			echo "Fehler ',\\ und \" nicht erlaubt!";
			die;
			}
			
		if($password != $password_repeat OR $username == "" OR $password == "" OR $email == "" or $spam != "" or $agb == "" or preg_match('/\s/',$username)) {
				echo "Eingabefehler. Bitte alle Felder korrekt ausfüllen. <a href=\"javascript:history.back()\">Zurück</a>"; 
				exit;
			}
		else{
			//global (low-risk)
			global $db_my;
			//escape string
			$username = $db_my->escape_string($username);
			$password = $db_my->escape_string($password);
			$email = $db_my->escape_string($email);
			///query next id
			$query = "SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name = '". $db_my->prefix ."users'"; 
			$result = $db_my->query($query); 
			$row = $result->fetch_array();   
			$nextId = $row['AUTO_INCREMENT'];
			unset($row);
			$result->free();
			//loginkey
			$loginkey = mcrypt_create_iv(50, MCRYPT_DEV_URANDOM);
			$loginkey = substr(bin2hex($loginkey), 0, 50);
			$loginkey = $nextId."_".$loginkey;
			//password hash
			$password = password_hash($password, PASSWORD_BCRYPT);
			$password = $db_my->escape_string($password);
			//query final register
			$query = "SELECT id FROM users WHERE username LIKE '$username'"; 
			$result = $db_my->query($query); 
			if(mysqli_num_rows($result) == 0) { 
				$query = "INSERT INTO ". $db_my->prefix ."users (id,username,password,algo,salt,loginkey,email,usergroup,admin,moderator)
				VALUES ('null','$username','$password','bcrypt','','$loginkey','$email','0','0','0')
				"; 
				if($db_my->query($query)){
					echo"Registriert";
				}
				
				/*
				$stmt = $db_my->prepare("INSERT INTO users (id,username,password,algo,salt,loginkey,email,usergroup,admin,moderator)
				VALUES ('null',?,?,'bcrypt','',?,?,'0','0','0')"); 
				$stmt->bind_param("ssss", $username, $password, $loginkey, $email);
				$stmt->execute();
					*/
			}	else{
				echo"Name bereits verwendet";
			}
		}
	}
		
		
	function profil_edit(){
		global $db_my;
		$db = $db_my;
		//
		$profil_username = $_SESSION["username"];
		$profil_username = $db->escape_string($profil_username);		
		$profil_password = $_POST["profil_password"]; 
		$profil_password = $db->escape_string($profil_password);	
		//
		$new_password = $_POST["edit_password"];
		$new_password = $db->escape_string($new_password);
		$new_password_repeat = $_POST["edit_password_repeat"];
		if ($profil_username != "" or $profil_password != ""){
			$query = $db->query("SELECT username, password, algo, salt FROM ". $db_my->prefix ."users WHERE username LIKE '$profil_username' LIMIT 1");
			$row = $query->fetch_object();
			//
			if($row->algo == "none"){
				$profil_password_hashed = $profil_password;
			}
			elseif ($row->algo != "bcrypt"){
			$profil_password_hashed = hash($row->algo, md5($row->salt).md5($profil_password)); 
			}	else{
				if (password_verify($profil_password, $row->password)) {
					$profil_password_hashed = $row->password;
				}
			}
			//
			if($profil_password_hashed == $row->password) {
				if($new_password == $new_password_repeat and $new_password != '')
				{
				$new_password = password_hash($new_password, PASSWORD_BCRYPT);
				$new_password = $db->escape_string($new_password);
				//$salt = hash('crc32',mt_rand(10, 99).md5($profil_username).mt_rand(10, 99));
				//$new_password = hash('sha256', md5($salt).md5($new_password));
				$query = "UPDATE ". $db_my->prefix ."users SET password='$new_password'	WHERE username='$profil_username'";
				$query = $db_my->query($query);
				$query = "UPDATE ". $db_my->prefix ."users SET salt =''	WHERE username='$profil_username'";
				$query = $db_my->query($query);
				$query = "UPDATE ". $db_my->prefix ."users SET algo ='bcrypt'	WHERE username='$profil_username'";
				$query = $db_my->query($query);
				echo "Passwort <input type='text' value='geändert' readonly> <br>";
				}	else{
				echo "Passwort <input type='text' value='nicht geändert' readonly> oder Wiederholung falsch <br>";
				}
			}	else {
				echo "Passwort falsch";
			}
		}	else {
			echo "Hallo ".$db_username.": Keine Änderung am Profil.";
		}
	}
			
			///
			
	function logout(){
		global $db_my;
		$db = $db_my;
		if (!isset($_SESSION["username"])){
			echo "Nicht eingeloggt";
			exit;
			}
		$username = $_SESSION["username"];
		$username = $db_my->escape_string($username);
		$query = "SELECT id FROM ". $db_my->prefix ."users WHERE username = '$username'";
		$result = $db->query($query); 
		$row = $db->fetch_object($result);
		$id=$row->id;
		//loginkey
		$loginkey = mcrypt_create_iv(50, MCRYPT_DEV_URANDOM);
		$loginkey = substr(bin2hex($loginkey), 0, 50);
		$loginkey = $id."_".$loginkey;
		$query = "UPDATE ". $db_my->prefix ."users SET loginkey='$loginkey'	WHERE username='$username'";
		$result = $db->query($query);
		if($result and session_destroy()){
		echo"
		<h2>Ihre Sessions wurden gelöscht</h2>
		<!--Neuen Key erhalten-->
		<br><a class='button' href='index.php'>Weiter</a>
		";
		}
	}
}

///LOGIN_TOKEN		
class user_login_token{
		function user_login_token_verify($loginkey){
			global $db_my;
			if($loginkey != "" or $loginkey == "false"){
				$loginkey = $db_my->escape_string($loginkey);
				$query = "SELECT id,username,loginkey,email,usergroup,moderator,admin FROM ". $db_my->prefix ."users WHERE loginkey LIKE '$loginkey' LIMIT 1";
				$result = $db_my->query($query);		
				$row = $result->fetch_object();
				
				if($result->num_rows == 0) {
					setcookie("loginkey", "false", time() - 3600);
					header( 'Location: ?loginkey=false' ) ;
				}	elseif(!isset ($_SESSION["username"])){
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
					$_SESSION["uid"] = $row->id;
					$_SESSION["username"] = $row->username;		
					if($row->email != ""){
						$_SESSION["email"] = $row->email;
					}
					if($row->moderator == 1){
						$_SESSION["moderator"] = "1";
					}
					if($row->admin == 1){
						$_SESSION["admin"] = "1";
					}
					
					if($row->usergroup != ""){
						$_SESSION["mitglied"] = $row->usergroup;
					}
					
					$_SESSION["loginkey"] = $row->loginkey;
				}
			}
		}		
	}
///
function login_form() {
	
	echo"
	
<!--nicht ?processed=1 daher keine Login-->
	<div style='text-align:center;'><h3>Login</h3>
	<form name='fwlogin' action='login.php?processed=1' method='post'>
		<input type='text' placeholder='Benutzername' size='24' maxlength='150'
		name='username'><br>
		<input placeholder='Passwort' type='password' size='24' maxlength='50'
		name='password'><br>
		Merken: <input type='checkbox' value='1' name='loginkey_active' checked='checked'>
		<p class='nodisplay'>
		<label for='email2'>E-Mailbestätigung (leer lassen):</label>
		<input id='email2' name='email2' size='60' value='' />
		<input type='submit' style='position: absolute; left: -9999px; width: 1px; height: 1px;'/>
		</p>
	</form></div>	
	<br>
	<a href='#' onclick='document.fwlogin.submit();' class='button'>Login</a> 
	<!--<a href='' class='button'>Passwort vergessen?</a>-->
	<a href='register.php' class='button'>Registrieren</a>
	";	
	}
		

/*function member_mybb()
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
		$anzahl = 0;
		//
		mysql_select_db($db) or die ("Datenbank konnte nicht ausgewählt werden"); 
		$db_abfrage_1 = "SELECT username, usergroup, displaygroup, additionalgroups, uid FROM mybb_users WHERE displaygroup = '$admin' ORDER BY username"; 
		$db_ausgabe_1=mysql_query($db_abfrage_1,$link_db);
		
		echo "<div align='center' style='font-size: 1.5em;'>
		<table width='80%'>";
		
			
		while ($row1 = mysql_fetch_assoc($db_ausgabe_1))
			{
			$rows1[] = $row1 ;
			}
			foreach($rows1 as $row1){

			$anzahl = $anzahl + 1;
			
		
			echo "<tr><td><b>".$row1[username]."</b></td>";
			echo "<td>Leitung";
			echo "<tr><td colspan='2'><br></td></tr>";
			}
		$db_abfrage_2 = "SELECT username, usergroup, displaygroup, additionalgroups, uid FROM mybb_users WHERE displaygroup = '$veteran' ORDER BY username"; 
		$db_ausgabe_2 = mysql_query($db_abfrage_2,$link_db);
		
			
		while ($row2 = mysql_fetch_assoc($db_ausgabe_2))
			{
			$rows2[] = $row2 ;
			}
			foreach($rows2 as $row2){
			
			$anzahl = $anzahl + 1;
		
			echo "<tr><td><b>".$row2[username]."</b></td>";
			echo "<td>Veteran";
			echo "<tr><td colspan='2'><br></td></tr>";
			}
		$db_abfrage_3 = "SELECT username, usergroup, displaygroup, additionalgroups, uid FROM mybb_users WHERE displaygroup = '$mitglied' ORDER BY username"; 
		$db_ausgabe_3=mysql_query($db_abfrage_3,$link_db);
	
		while ($row3 = mysql_fetch_assoc($db_ausgabe_3))
			{
			$rows3[] = $row3 ;
			}
			foreach($rows3 as $row3){
			$anzahl = $anzahl + 1;
			echo "<tr><td><b>".$row3[username]."</b></td>";
			echo "<td>Mitglied";
			echo "<tr><td colspan='2'><br></td></tr>";
			}
			
		$db_abfrage_4 = "SELECT username, usergroup, displaygroup, additionalgroups, uid FROM mybb_users WHERE displaygroup = '$maskottchen' ORDER BY username"; 
		$db_ausgabe_4=mysql_query($db_abfrage_4,$link_db);
	
		while ($row4 = mysql_fetch_assoc($db_ausgabe_4))
			{
			$rows4[] = $row4 ;
			}
			foreach($rows4 as $row4){
			$anzahl = $anzahl + 1;
			echo "<tr><td><b>".$row4[username]."</b></td>";
			echo "<td>Maskottchen";
			echo "<tr><td colspan='2'><br></td></tr>";
			}			
			
			
			echo "</table></div>";
			echo "<h3 align='center'>Mitgliederanzahl: ".$anzahl." </h3>";
		}*/
?>