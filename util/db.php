<?php 
	$host = "localhost";
	$username = "root";
	$password = "";
	$dbname = "cnss2";

	if(!$con = mysqli_connect($host,$username,$password,$dbname))
		echo mysqli_connect_error();
	else
		//echo "connected successfully to db";
?>