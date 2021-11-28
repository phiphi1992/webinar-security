<?php
$target_dir = "upload/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
	// Check file size
	if ($_FILES["fileToUpload"]["size"] > 500000) {
	  echo "<span class='error'>Sorry, your file is too large.</span>";
	  $uploadOk = 0;
	}
	
	// Allow certain file formats
	// if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
	//   echo "<span class='error'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</span>";
	//   $uploadOk = 0;
	// }
	
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
	  echo "<span class='error'>Sorry, your file was not uploaded.</span>";
	// if everything is ok, try to upload file
	} else {
	  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
	    echo "<span class='success'>The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.</span>";
	  } else {
	    echo "<span class='error'>Sorry, there was an error uploading your file.</span>";
	  }
	}
}
?>
<!DOCTYPE html>
<html>
<body style="padding: 0;margin: 0;">
<style>
	*{box-sizing: border-box;}
	span.success{
		width: 100%;
	    display: block;
	    padding: 10px;
	    background: #188d27;
	    color: #fff;
	    font-size: 20px;
	    text-align: center;
	}
    span.error{
		width: 100%;
	    display: block;
	    padding: 10px;
	    background: #e1182b;
	    color: #fff;
	    font-size: 20px;
	    text-align: center;
	}
</style>
<form action="upload.php" method="post" enctype="multipart/form-data" style="width: 600px;margin: 100px auto;">
  Select image to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
</form>

</body>
</html>