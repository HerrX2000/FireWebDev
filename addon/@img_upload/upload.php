<?php
//Proto Type
class img_upload{
	function form (){
		echo "
			 <form action=\"addon/@img_upload/init.php\" method=\"post\" enctype=\"multipart/form-data\">
    Select image to upload:
    <input type=\"file\" name=\"fileToUpload\" id=\"fileToUpload\">
    <input type=\"submit\" value=\"Upload Image\" name=\"submit\">
</form>
";
	}
	function upload($uid=""){
		if ($uid==""){
			echo "Error";
			exit;
		}
$target_dir = "../../uploads/avatar/";
$target_file = $target_dir . $uid . ".jpg";
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Avatare exists.";
	$uploadOk = 1;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 64*1024) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
	echo "<script type=\"text/javascript\">
				setTimeout(function () { location.href = \"../../index.php\"; }, 5000);
			</script>
	";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		echo "<script type=\"text/javascript\">
				setTimeout(function () { location.href = \"../../index.php\"; }, 2000);
			</script>
	";
    } else {
        echo "Sorry, there was an error uploading your file.";
		echo "<script type=\"text/javascript\">
				setTimeout(function () { history.back() }, 5000);
			</script>
	";
    }
}

		
		
}
}
?>
