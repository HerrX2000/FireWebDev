<?php
//Proto Type
session_start();
include("upload.php");
$img_upload = new img_upload();
$img_upload->upload($uid=$_SESSION["uid"]);
?>
