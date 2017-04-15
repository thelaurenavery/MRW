<?php
	include 'config.php';

	$mysqli = new mysqli($config['mysql_server'], $config['mysql_user'], $config['mysql_password'], $config['mysql_db']);
	if ($mysqli->connect_errno) {
		printf("Connection failed: %s \n", $mysqli->connect_error);
		exit();
	}

	$rows = [];

	$mysqli->set_charset("utf8");

	// set some post stuff up here
	$genreType = $_GET["genre"];	

	$myQuery = "SELECT * FROM tbl_movies";
	$result = mysqli_query($mysqli, $myQuery);

	while ($r = mysqli_fetch_assoc($result)) {
    	$rows[] = $r;
	}	

	echo json_encode($rows);			
?>