<?php
session_start();
require("global.php");
require("core/core_exp.php");
core($modul="default", "login","show");
?>