<?php 
//entries	
//costum
class comments{
	function init($table){
		$init=$table;
		$this->init=$init;
		global $c;
		global $db_my;
		
		$table_n = $table;
		$table = $db_my->escape_string($table);
		$table = "comments_".$table;

		$query="SELECT id, username, comment from ". $db_my->prefix ."$table ORDER BY id DESC";

		//
		$area_table=$db_my->query($query, $hide_errors=1, $write_query=0);
		
		$result=$db_my->query($query, $hide_errors=1, $write_query=0);
		//
		if($db_my->num_rows($result)!=0){
			while ($row = $db_my->fetch_assoc($result))
			{
			$rows[] = $row ;
			}
			// Errorhandel
			if(!isset($rows)) {
				echo "Nicht gefunden";
				exit;
			}
			$results = array();
			$index=0;
			foreach($rows as $row){
				$results[$index]=array($row['id'], $row['username'], $row['comment']);
				$index++;
			}
			$return = array("result" => $result, "table" => $table_n, "results" => $results);
			$this->cur=$return;
			return $return;
		}
		else{
			return false;
		}
	}
	function show(){
		$results = $this->cur['results'];
		foreach ($results as $result){
			echo "Kommentar: ".$result[2]."<br>";
		}
		
	}
}

function show_comments($table='',$limit='',$spalten='')
		{
			global $db_my;
			$table = $db_my->escape_string($table);
			//$db_my->query("SET NAMES 'utf8'", $hide_errors=0, $write_query=0);
			//
			$query="SELECT Benutzer, Kommentar from ". $db_my->prefix ."$table ORDER BY id DESC LIMIT $limit";
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