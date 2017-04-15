<?php
//echo "From read.php";
	
	function getAll($tbl){
		require_once("connect.php");
		$queryAll = "SELECT  * FROM {$tbl}";
		//echo $queryAll;
		$runAll = mysqli_query($link, $queryAll);

		if($runAll){
			return $runAll;
		}else{
			$error = "There was an error accessing this information. Please contact Web Admin for tech support.";
			return $error;
		}

		mysqli_close($link);
	}

	function filterType($tbl,$tblcat,$tblLink,$colMovie,$colCat,$colCatName,$filter){
			require_once("connect.php");
				$queryFilter = "SELECT * FROM $tbl, $tblcat, $tblLink WHERE $tbl.$colMovie=$tblLink.$colMovie AND $tblcat.$colCat=$tblLink.$colCat AND $tblcat.$colCatName='{$filter}'";

				$runFilter = mysqli_query($link,$queryFilter);

				if($runFilter){
					return $runFilter;
				}else{
					$error = "There was an error accessing this information. Please contact Web Admin for tech support.";
					return $error;
				}
			mysqli_close($link);
		}

	function getSingle($tbl,$col,$id){
		require_once("connect.php");

		$querySingle = "SELECT * FROM {$tbl} WHERE {$col}={$id}";
		echo $querySingle;

		

		mysqli_close($link);
	}

	function specificMovie($name){
		require_once("connect.php");

		$queryMovie = "SELECT * FROM tbl_movies WHERE movies_title= '{$name}'";


		$specificMovieFilter = mysqli_query($link,$queryMovie);

				if($specificMovieFilter){
					return $specificMovieFilter;
				}else{
					$error = "There was an error accessing this information.";
					return $error;
				}
		

		mysqli_close($link);
	}
?>