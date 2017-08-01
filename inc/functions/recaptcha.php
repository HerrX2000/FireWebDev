<?php 
$settings ['recaptcha_key'] = "6LfriyETAAAAADZQ65lKV9zcinpwPsdUWhcicdvp";
	
	function recaptcha(){
		$settings ['recaptcha'] = 1;
		$settings ['recaptcha_key'] = "6LfriyETAAAAADZQ65lKV9zcinpwPsdUWhcicdvp";
		if ($settings ['recaptcha'] == 1){
		echo "<div class=\"g-recaptcha\" data-sitekey=\"".$settings ['recaptcha_key']."\"></div>";
		}
	}
?>