<?php 
//entries	
//costum
function show_comments($table='',$limit='',$spalten='')
		{
			global $db_my;
			$table = $db_my->escape_string($table);
			//$db_my->query("SET NAMES 'utf8'", $hide_errors=0, $write_query=0);
			//
			$query="SELECT email, Benutzer, Kommentar from ". $db_my->prefix ."$table ORDER BY id DESC LIMIT $limit";
			//
			$result=$db_my->query($query, $hide_errors=0, $write_query=0);
			//
			$anzahl = 0;
			$gesamt_anzahl = 0;
			while($ausgabe_fertig=$db_my->fetch_assoc($result))
			{
			$anzahl = $anzahl + 1;
			$gesamt_anzahl = $gesamt_anzahl + 1;
			echo "<textarea cols='26' rows='5' style='background:#F3F3F3;' readonly>";
			foreach($ausgabe_fertig as $key=>$wert){
			echo $wert;
			}
			echo "</textarea>";
			if ($anzahl==$spalten)
			{
				echo "<br>";
				$anzahl=0;
			}
		}
		if ($gesamt_anzahl==0)echo "Kein Eintrag";
		}
	
function add_comment_mysql($table='')
	{	
			if ($table != "bug_report" and $table != "comments"){
				
			}
			if (!isset($_SESSION["username"])) 
			{ 
				$email=$_POST["email"];
			}
			else{
				$email=$_SESSION["email"];
			}
			if (isset($_POST["kommentar"])){
			global $db_my;
			//
			$name=$_POST["name"];
			$kommentar=$_POST["kommentar"];
			$spam_protection = $_POST["email2"];			
			$datum = date("Y-m-d",time()); 
			//
			//
			//$db_my->query("SET NAMES 'utf8'", $hide_errors=0, $write_query=0);
			//
			
			$name = $db_my->escape_string($name);
			$email = $db_my->escape_string($email);
			$kommentar = $db_my->escape_string($kommentar);
			$datum = $db_my->escape_string($datum);
			$query="INSERT INTO ". $db_my->prefix ."$table VALUES (NULL,'".$name.": "."','".$email."','".$kommentar."','".$datum."')";
			$result=$db_my->query($query, $hide_errors=0, $write_query=0);
		}
		else{
			echo"Kein Kommentar<h2 style=\"text-align:center;\">Nicht</h2>";
		}
	}
//Entries end
?>