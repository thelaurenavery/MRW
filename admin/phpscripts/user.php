<?php

	function editUser($id,$fname,$lname,$username,$password,$email){
		include("connect.php");

		//just added that when someone edits their accounts, it changes user_edited to 'yes'
		$updateString = "UPDATE tbl_user SET user_fname = '{$fname}', user_lname='{$lname}', user_uname ='{$username}', user_password='{$password}',user_email = '{$email}', user_edited = 'yes' WHERE user_id = {$id}";
		$updateQuery = mysqli_query($link,$updateString);

		if($updateQuery){
			$message = "Your account has been successfully edited.";
			redirect_to('admin_index.php');
		}else{
			$message = "Not gonna happen";
			return $message;
		}
	}

	function editUsers($id,$fname,$lname,$username,$email,$level,$suspend,$delete){
		include("connect.php");

		date_default_timezone_set('America/Detroit');
		$date = new dateTime();
		$properDate = $date -> format('Y-m-d H:i:s');

		//just added that when someone edits their accounts, it changes user_edited to 'yes'

		if($delete === 'yes'){
			$updateDelete = "DELETE FROM tbl_user WHERE user_id = '{$id}'";
			$updateDeleteQuery = mysqli_query($link,$updateDelete);
		}

		if($suspend === 2 || $suspend === '2'){

			$updateString = "UPDATE tbl_user SET user_fname = '{$fname}', user_lname='{$lname}', user_uname ='{$username}', user_email = '{$email}', user_level = '{$level}', user_suspend = 'no', user_attempts = '0', user_create_date = '$properDate' WHERE user_id = '{$id}'";
			$updateQuery = mysqli_query($link,$updateString);
		}else{

			$updateString = "UPDATE tbl_user SET user_fname = '{$fname}', user_lname='{$lname}', user_uname ='{$username}', user_email = '{$email}', user_level = '{$level}' WHERE user_id = '{$id}'";
			$updateQuery = mysqli_query($link,$updateString);

		}

		if($updateQuery || $updateDeleteQuery){
			redirect_to('admin_editusers.php');
		}else{
			$message = "Not gonna happen";
			return $message;
		}
	}

	
	function getUser($id){
		require_once('connect.php');

		$userIdQuery = "SELECT * FROM tbl_user WHERE user_id = {$id}";

		$id_set = mysqli_query($link, $userIdQuery);

		if($id_set){
			$found_id = mysqli_fetch_array($id_set, MYSQLI_ASSOC);
			return $found_id;
		}else{
			$message = "Id doesn't match.";
			return $message;
		}

		mysqli_close($link);
	}

	function getAllUsers(){
		require_once('connect.php');

		$userQuery = "SELECT * FROM tbl_user WHERE user_level = 'admin'";

		$user_set = mysqli_query($link, $userQuery);

		if($user_set){
			return $user_set;
		}else{
			$message = "Id doesn't match.";
			return $message;
		}

		mysqli_close($link);
	}
	
	function createUser($fname,$lname,$username,$level,$email){

		require_once("connect.php");

		date_default_timezone_set('America/toronto');
		$date = new dateTime();
		$properDate = $date -> format('Y-m-d H:i:s');

		$randomPassword = bin2hex(openssl_random_pseudo_bytes(5));

		$header = "From: Organ Donation Ontario<jeanp162@hp192.hostpapa.com>";

		$ip = 0 ;

		//added values to the user_edited and user_created_date columns
		$userstring = "INSERT INTO tbl_user VALUES (NULL,'{$fname}','{$lname}','{$username}','{$randomPassword}','$ip','{$level}','1000-01-01 00:00:00','1000-01-01 00:00:00','0','{$email}','$properDate','no','no')";

		$checkUser = "SELECT user_id FROM tbl_user WHERE user_uname = '{$username}'";

		//changed message to better reflect what is going on
		$body = "Your user name is: {$username}\n\n Your password is: {$randomPassword}\n\n To login please follow this link: https://goo.gl/55YYKC \n\n You will need to change your password the first time you login. For security mesures, you will be given 24 hours to login and change your password. If you do not, your account will be suspended and you will need to contact an admin.";

		//echo $userString;

		$userquery = mysqli_query($link,$userstring);

		if(isset($userquery)){
			mail($email, "Here's your username and password for your company login.",$body,$header);
			// echo $body;
			$message = "<h2 class=\"roboto blackH2Red\">User was added</h2>";
			return $message;
		}else{
			$message = "There was an error adding the user to the database.";
		}


		mysqli_close($link);
	}
?>