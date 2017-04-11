<?php 
	
	//ini_set ('display_errors', 1); THESE TWO LINES ARE FOR MAC - error displaying turned off automatically 
	//error_reporting(E_ALL);

	require_once("admin/phpscripts/init.php");
	$tbl="tbl_movies"; 
	if(isset($_GET['filter'])) {
		$filter = $_GET['filter'];
		//echo $filter;
		$tbl1 = "tbl_cat";
		$tbl2 = "tbl_l_mc";
		$col = "movies_id";
		$col1 = "cat_id";
		$col2 = "cat_name";
		$getMovies = filterType($tbl,$tbl1,$tbl2,$col,$col1,$col2,$filter);

	} else {
	$getMovies = getAll($tbl);
	//echo $getMovies;
	}
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Welcome to the best Blu Ray collection</title>
<link rel="stylesheet" href="css/foundation.css"/>
<link rel="stylesheet" href="css/app.css"/>
<link href="https://fonts.googleapis.com/css?family=Grand+Hotel|Quicksand:300" rel="stylesheet">
</head>

<body>
<?php
	include("includes/nav.html");
?>	
<section>
	<h2>Our selection of movies...</h2>
	<?php
		if(!is_string($getMovies)){
			//echo "I'm an object!";
			while($row = mysqli_fetch_array($getMovies)){
				echo "<img src=\"images/{$row['movies_thumb']}\" alt=\"{$row['movies_title']}\">";
				echo "<h3>{$row['movies_title']}</h3>";
				echo "<p>{$row['movies_year']}</p>";
				echo "<a href=\"details.php?id={$row['movies_id']}\">More details...</a><br><br>";
			}
		} else {
			//echo "nope...";
		}

	?>
</section>

<?php 
	include("includes/footer.html");
?>

	<script src="js/vendor/jquery.min.js"></script>
    <script src="js/vendor/what-input.min.js"></script>
    <script src="js/foundation.js"></script>
    <script src="js/app.js"></script>
    <script src="js/icons.js"></script>
    <script src="js/ScrollToPlugin.min.js"></script>
    <script src="js/gallery.js"></script>
</body>
</html>
