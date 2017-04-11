<?php
	
	function redirect_to($location) {
		if($location != NULL) {
			header("Location: {$location}");
			exit;
		}
	}
	
function addMovie($fimg,$thumb,$title,$year,$storyline,$runtime,$trailer,$price,$cat) {
	include("connect.php");
	//echo "from addMovie()";
	$fimg = mysqli_real_escape_string($link, $fimg); //gets right of quotes etc
	
	if($_FILES['movie_fimg']['type'] == "image/jpg" || $_FILES['movie_fimg']['type'] == "image/jpeg") {
		//echo "this is a jpg or jpeg";
		$targetpath = "../images/{$fimg}";
		if(move_uploaded_file($_FILES['movie_fimg']['tmp_name'],$targetpath)) { //tmp name stores a bunch of info
			//echo "file moved";
			$orig = "../images/{$fimg}";
			$th_copy = "../images/{$thumb}";
			if(!copy($orig, $th_copy)) {
				echo "Failed to copy";
			}
			
			//$size = getimagesize($orig); //gets dimensions of image
			//echo $size[0]." x ".$size[1];
			
			$qstring = "INSERT INTO tbl_movies VALUES(NULL, '{$thumb}','{$fimg}','noBG.jpg','{$title}','{$year}','{$storyline}','{$runtime}','{$trailer}','{$price}')";
			//echo $qstring;
			
			$result = mysqli_query($link, $qstring);
			
			if($result == 1) {
				$qstring2 = "SELECT * FROM tbl_movies ORDER BY movies_id DESC LIMIT 1";
				$result2 = $row['movies_id'];
				
				$row = mysqli_fetch_array($result2);
				$lastID = $row['movies_id'];
				
				$qstring3 = "INSERT INFO tbl_l_mc VALUES(NULL, '{$lastID}','{$cat}')";
				$result3 = mysqli_query($link,$qstring3);
				redirect_to("admin_index.php");
			}
		}
		
	}else{
		echo "No fuckin gifs";
	}
	
	mysqli_close($link);
}
?>