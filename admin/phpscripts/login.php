<?php
	
	//echo "login.php";

	function logIn($username, $password){
		require_once("connect.php");

			//Set Timezone
			date_default_timezone_set('America/Detroit');


			$username = mysqli_real_escape_string($link,$username);
			$password = mysqli_real_escape_string($link,$password);

			//sql queries
			$loginString = "SELECT * FROM tbl_user WHERE user_uname ='{$username}' AND user_password = '{$password}'";
			$userAttempts_and_lockout = "SELECT user_attempts, user_lockout_date FROM tbl_user WHERE user_uname = '{$username}'";
			//$db_usernamesString = "SELECT user_uname FROM tbl_user";

			$user_set = mysqli_query($link, $loginString);
			$user_attempts_query = mysqli_query($link, $userAttempts_and_lockout);

			$date = new dateTime();
			$properDate = $date -> format('Y-m-d H:i:s');

			//if user properly logged in
			if( mysqli_num_rows($user_set)){

				$found_user = mysqli_fetch_array($user_set, MYSQLI_ASSOC);
				//$all_usernames = mysqli_fetch_array($db_usernamesString, MYSQLI_ASSOC);

				$id = $found_user["user_id"];
				$attempts = $found_user['user_attempts'];
				$lockout_date = $found_user['user_lockout_date'];
				$suspend = $found_user['user_suspend'];
				$ip = $_SERVER["REMOTE_ADDR"];

				//added these variables to check is the user has edited their account and when their account was created
				$user_modified = $found_user['user_edited'];
				$user_created_date = $found_user['user_create_date'];

				//made sessions in case I needed them for later projects
				$_SESSION['users_creds'] = $id;
				$_SESSION['users_uname'] = $found_user['user_uname'];
				$_SESSION['users_fname'] = $found_user['user_fname'];
				$_SESSION['users_date'] = $found_user['user_login_date'];
				$_SESSION['users_attempts'] = $attempts;
				$_SESSION['users_lockout_date'] = $lockout_date;
				$_SESSION['users_level'] = $found_user['user_level'];
				//$_SESSION['allUnames'] = $all_usernames['user_uname'];

				//will check if user is locked out
				if($attempts>2){

					if((strtotime($properDate) - strtotime($lockout_date))<1800){

					$message = "You are currently locked out. Please wait ".(30 - floor((strtotime($properDate) - strtotime($lockout_date))/60))." minutes before trying again.";

					return $message;

					//if user is locked out but it's been 30mins it will log them back in
					}else{$updateString = "UPDATE tbl_user SET user_ip = $ip WHERE user_id = {$id}";
					$updateQuery = mysqli_query($link, $updateString);
				
					$currentDate = "UPDATE tbl_user SET user_login_date = '{$properDate}' WHERE user_uname = '{$username}'";
					$updateQuery = mysqli_query($link, $currentDate);
				
					$updateAttempts = "UPDATE tbl_user SET user_attempts = '0'  WHERE user_uname = '{$username}'";
					$updateQuery = mysqli_query($link, $updateAttempts);

				}

				//if user isn't locked out it logs them in
				}else{

					//checks if the user has edited their account yet
					if($user_modified === 'no'){

						//if not, it checks the date it was created and calculates if it's been 24 hours since
						if((strtotime($properDate) - strtotime($user_created_date))>86400){

							//if it has been 24 hours, it suspends the user and shows a message
							$suspendString = "UPDATE tbl_user SET user_suspend = 'yes' WHERE user_uname = '{$username}'";
							$updateQuery = mysqli_query($link, $suspendString);

							$message = "We're sorry to inform you that too much time has passed since the creation of your account. For security reasons we have suspended your account. Please contact an admin.";

							return $message;

						//if it hasn't been 24 hours, the user is redirected to edit their page
						}else if($suspend === 'yes'){

							$message = 'We are sorry to inform you that your account has been suspended for security reasons. Please contact an administrator.';
							return $message;

						}else{
							$currentDate = "UPDATE tbl_user SET user_login_date = '{$properDate}' WHERE user_uname = '{$username}'";
							$updateQuery = mysqli_query($link, $currentDate);
							redirect_to("admin_edituser.php");
						}

					}else{
						$updateString = "UPDATE tbl_user SET user_ip = $ip WHERE user_id = {$id}";
						$updateQuery = mysqli_query($link, $updateString);
				
						$currentDate = "UPDATE tbl_user SET user_login_date = '{$properDate}' WHERE user_uname = '{$username}'";
						$updateQuery = mysqli_query($link, $currentDate);
				
						$updateAttempts = "UPDATE tbl_user SET user_attempts = '0'  WHERE user_uname = '{$username}'";
						$updateQuery = mysqli_query($link, $updateAttempts);
					}

				}


				redirect_to("admin_index.php");

			//if user's password is incorrect	
			}else{

				$found_user = mysqli_fetch_array($user_attempts_query, MYSQLI_ASSOC);
				$attempts = $found_user['user_attempts'];
				$lockout_date = $found_user['user_lockout_date'];

				//it first checks if the user is locked out
				if($attempts>2){

					if((strtotime($properDate) - strtotime($lockout_date))>1800){
						$updateLockout = "UPDATE tbl_user SET user_lockout_date = '$properDate'  WHERE user_uname = '{$username}'";
						$updateQuery = mysqli_query($link, $updateLockout);
						$message = "You are currently locked out. Please wait 30 minutes before trying again.";
						return $message;
					}else{
					$message = "You are currently locked out. Please wait ".(30 - floor((strtotime($properDate) - strtotime($lockout_date))/60))." minutes before trying again.";
					return $message;
					}

				//if not already locked out, at this point they are locked out and we log the time they were locked out so we can calculate 30 mins from this time
				}else if($attempts>1){

					$updateLockout = "UPDATE tbl_user SET user_lockout_date = '$properDate'  WHERE user_uname = '{$username}'";
					$updateQuery = mysqli_query($link, $updateLockout);

					$updateAttempts = "UPDATE tbl_user SET user_attempts = user_attempts + 1  WHERE user_uname = '{$username}'";
					$updateQueryAttempts = mysqli_query($link, $updateAttempts);

					$message = "You are currently locked out. Please wait 30 minutes before trying again.";
					return $message;

				//if none of the above, just add a failed attempt to the user
				}else{

					$updateAttempts = "UPDATE tbl_user SET user_attempts = user_attempts + 1  WHERE user_uname = '{$username}'";
					$updateQuery = mysqli_query($link, $updateAttempts);

					$message ="Wrong username or password.<br> You have <span>".(2- $attempts)."</span> attempts left.";
					return $message;
				}
			}

			


		mysqli_close($link);
	}
?>