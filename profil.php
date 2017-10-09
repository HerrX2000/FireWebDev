<?php
session_start();
if (isset($_SESSION["username"])) 
			{
include("core/core.php");
			}	
else{
header('Location: login.php');
}
?>	