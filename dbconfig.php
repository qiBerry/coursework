<?php

$DBhost = "localhost";
$DBuser = "system_user";
$DBpassword ="SuperHardPass61";
$DBname="upload_db";

$conn = mysqli_connect($DBhost, $DBuser, $DBpassword, $DBname); 

if(!$conn){
	die("Connection failed: " . mysqli_connect_error());
}

?> 
