<?php
    //Mac only
    //init_set("display_errors",1);
    //errpr_reporting(E_ALL);
    require_once("admin/phpscripts/init.php");
    $tbl = "tbl_movies";
    if(isset($_GET['filter'])){
           // echo $_GET['filter'];
        $filter = $_GET['filter'];
        $tblcat = "tbl_cat";
        $tblLink = "tbl_l_mc";
        $colMovie = "movies_id";
        $colCat = "cat_id";
        $colCatName = "cat_name";
        $getMovies = filterType($tbl,$tblcat,$tblLink,$colMovie,$colCat,$colCatName,$filter);
        /*SELECT * FROM $tbl, $tblcat, $tblLink WHERE $tbl.$colMovie=$tblLink.$colMovie AND $tblcat.$colCat=$tblLink.$colCat AND $tblcat.$colCName='{$filter}'*/
    }else if(isset($_GET['movies_title'])){
        $name = $_GET['movies_title'];
        $getMovies = specificMovie($name);
    }else{
    $getMovies = getAll($tbl);
    }

?>

<html>
<head>
<meta charset="utf-8">
<title>Trailer Time</title>
<link rel="stylesheet" href="css/foundation.css" />
<link rel="stylesheet" href="css/app.css" />
</head>

<body>

	<header>
        <a href="index.php" id="home">Home</a>
		<h1>Trailer Time</h1>
			<h2>-THE INTERNETS BEST MOVIE DATABASE-</h2>

			<div id="autocomplete-container">  
  				<input type="search" autofocus name="autofocus sample" placeholder="search movies..." id="autocomplete-input"></input>
  				<ul id="autocomplete-results">
                </ul>
			</div>
	</header>
        
        <section class="row">
        	<h2 class="hide">Our Movie Selection</h2>

            <?php
            include("includes/nav.html");
            ?>

            <div id="movieSelection">
            </div>

        </section>
        
    <script src="js/vendor/jquery.min.js"></script>
    <script src="js/vendor/what-input.min.js"></script>
    <script src="js/vendor/foundation.min.js"></script>
    <script src="js/app.js"></script>
</body>
</html>
