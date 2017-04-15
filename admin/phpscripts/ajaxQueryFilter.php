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
	$filter = $_GET["filter"];	

	$myQuery = "SELECT * FROM tbl_movies, tbl_cat, tbl_l_mc WHERE tbl_movies.movies_id=tbl_l_mc.movies_id AND tbl_cat.cat_id=tbl_l_mc.cat_id AND tbl_cat.cat_name='$filter'";
	$result = mysqli_query($mysqli, $myQuery);

	while ($r = mysqli_fetch_assoc($result)) {
    	$rows[] = $r;
	}	

	echo json_encode($rows);			
?>