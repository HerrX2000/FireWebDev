<?php
session_start();
if (isset($_SESSION["username"])) 
			{
include("core/core.php");
			}	
else{
die("403: No access rights");
}
?>	