<?php
			//Set up connetion + passing permissions
	$user = "root";
	//$pass = "";//PC
	$pass = "root"; //MAC
	$url ="localhost";
	$db = "db_movies";

	$link = mysqli_connect($url,$user,$pass,$db);//PC

	//$link = mysqli_connect($url,$user,$pass,$db,"8888" or "8889");

	//Check the Connection

	if(mysqli_connect_errno()){
			printf("connection failed: %s\n",mysqli_connect_error());exit();
	}
?>