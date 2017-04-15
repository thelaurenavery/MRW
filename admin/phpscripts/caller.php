<?php
	require_once('init.php');

	if(isset($_GET['caller_id'])){

		$dir = $_GET['caller_id'];

		if($dir == "logout"){
			logged_out();
		}else{
			echo "Caller id was passed incorrectly. Unable to Logout.";
		}
	}else{
	}
?>