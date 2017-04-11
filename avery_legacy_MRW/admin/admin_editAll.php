<?php

	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	require_once('phpscripts/init.php');

?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Edit Content</title>
</head>

<body>
	<?php
		$tbl="tbl_movies";
		$col="movies_id";
		$id=1;
		single_edit($tbl,$col,$id);
	?>
</body>
</html>