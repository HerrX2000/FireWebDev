<?php
//Proto Type
function at_user_pictures ($width='42px',$height='42px'){
	if (file_exists("uploads/avatar/".$_SESSION["uid"].".jpg")){
		echo "<img src=\"uploads/avatar/".$_SESSION["uid"].".jpg\" alt=\"No Avatar\"  width=\"$width\" height=\"$height\">";
	}
	else{
		return false;
	}
}
?>
