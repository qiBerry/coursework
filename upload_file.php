<?php

header("Content-Type: application/json");
header("Acess-Control-Allow-Origin: *");
header("Acess-Control-Allow-Methods: POST"); // here is define the request method

include 'dbconfig.php'; // include database connection file
include 'functions.php';

$fileName  =  $_FILES['sendfile']['name'];
$tempPath  =  $_FILES['sendfile']['tmp_name'];
$fileSize  =  $_FILES['sendfile']['size'];
$fileContent = "";

if(empty($fileName))
{
	$errorMSG = json_encode(array("message" => "please select file", "status" => false));
	echo $errorMSG;
}
else
{
	$upload_path = 'upload/'; // set upload folder path

	$fileExt = strtolower(pathinfo($fileName,PATHINFO_EXTENSION)); // get image extension

	// valid image extensions
	$valid_extensions = array('txt');

	// allow valid image file formats
	if(in_array($fileExt, $valid_extensions))
	{
		//check file not exist our upload folder path
		while(file_exists($upload_path . $fileName))
		{
			//making new filename for file
			$pos = strlen($fileName) - 4;
			$fileName = substr_replace($fileName, "_copy", $pos, 0);
		}

		// check file size '5MB'
		if($fileSize < 5000000){
			$fileContent = translit(file_get_contents($tempPath));
			save_file($upload_path . $fileName, $fileContent);
			//move_uploaded_file($tempPath, $upload_path . $fileName); // move file from system temporary path to our upload folder path
		}
		else{
			$errorMSG = json_encode(array("message" => "Sorry, your file is too large, please upload 5 MB size", "status" => false));
			echo $errorMSG;
		}
	}
	else
	{
		$errorMSG = json_encode(array("message" => "Sorry, only TXT files are allowed", "status" => false));
		echo $errorMSG;
	}
}

// if no error caused, continue ....
if(!isset($errorMSG))
{
	$query =  mysqli_query($conn,'INSERT into tbl_image (name) VALUES("'.$fileName.'")');
	echo json_encode(array("message" => "Image Uploaded Successfully", "status" => true, "translited_message" => $fileContent));
}

?>