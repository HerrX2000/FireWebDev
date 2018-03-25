<?php
session_start();
require("global.php");
require(FW_SERVER_ROOT."/core/core_exp.php");
core($modul="default", "login","show");
?>