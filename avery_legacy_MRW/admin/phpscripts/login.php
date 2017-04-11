<?php
	//echo "welllll hello there!";
date_default_timezone_set('US/Eastern');
	function logIn($username, $password, $ip) {
		require_once("connect.php");
		$username = mysqli_real_escape_string($link,$username);//mysqli_real_escape_string escapes special characters in a string.
		$password = mysqli_real_escape_string($link,$password);
		$loginString = "SELECT * FROM tbl_user WHERE user_name= '{$username}' AND user_pass = '{$password}'"; //Selects ALL from tbl_user when the user and pass are correct.
		//echo $loginString;
		$attemptsLockouts = "SELECT user_attempts, user_lockdate FROM tbl_user WHERE user_name = '{$username}'"; //Gathers attempts and lockdate info from tbl_user when a correct username is entered.
		$user_attemptLock_query = mysqli_query($link,$attemptsLockouts);//mysqli_query sends a unique query to the currently active database associated with the specified link_identifier. Where there are none, sqli_connect will run.
		$user_set = mysqli_query($link, $loginString);
		$date = new dateTime();
	    $datefix = $date -> format('Y-m-d H:i:s');

		if(mysqli_num_rows($user_set)) { //mysqli_num_rows gathers number of rows from $user_set
			$found_user = mysqli_fetch_array($user_set, MYSQLI_ASSOC); //MYSQLI_ASSOC calls for the output of actual words associated with the numbers.
			//echo $found_user['user_fname'];
			$id = $found_user['user_id'];
			$_SESSION['users_creds'] = $id;  //Sessions are a way to preserve certain data across subsequent accesses. (Global variables kind of?)
			$_SESSION['users_name'] = $found_user['user_name'];
			$_SESSION['users_fname'] = $found_user['user_fname'];
			$_SESSION['users_date'] = $found_user['user_logtime'];
			$attempts = $found_user['user_attempts'];
			$lockdate = $found_user['user_lockdate'];
			
			$user_changed = $found_user['user_edited']; //this accesses the info from that column in DB
			$user_dateCreated = $found_user['user_dateCreated'];//this accesses the date created from DB

			if($attempts>2){ //This checks if the user is currently locked out, to prevent them from being able to try again before the time is up.
				if((strtotime($datefix) - strtotime($lockdate))<900){$message = "I just told you. You have ".(15- floor((strtotime($datefix) - strtotime($lockdate))/60))."minutes until you can try again.";
			return $message; //Floor means round/count down. (The last time stamp - the time of the lockout, in minutes.)
		} //strtotime is telling it to make a timestamp in seconds in order to compare the times. I couldn't get the minus sign to disappear on the actual page, though?
			
			}else{$updateString = "UPDATE tbl_user SET user_ip = '{$id}' WHERE user_id = {$id}";
					$updateQuery = mysqli_query($link, $updateString);
				
					$currentDate = "UPDATE tbl_user SET user_login_date = '{$datefix}' WHERE user_name = '{$username}'";
					$updateQuery = mysqli_query($link, $currentDate);
				
					$updateAttempts = "UPDATE tbl_user SET user_attempts = '0'  WHERE user_name = '{$username}'";
					$updateQuery = mysqli_query($link, $updateAttempts);
			}
			
			if($user_changed === 'no'){  //if user has not edited by 48 hours, account gets deleted.
				
				if((strtotime($datefix) - strtotime($user_dateCreated))>172800){  
					$message = "It has been to long, you are deleted!";
					
					$deleteString = "DELETE FROM tbl_user WHERE user_name = '{$username}'"; //this deletes it from the DB.
					$updateQuery = mysqli_query($link, $deleteString);
					
					return $message;
					}else{

							redirect_to("admin_edituser.php");
				}
				
			}

			if(mysqli_query($link, $loginString)) {
				$newdate = "UPDATE tbl_user SET user_logtime = '{$datefix}' WHERE	user_name = '{$username}'";
				$updateQuery = mysqli_query($link, $newdate); //This gathers/updates/stores the users login time in the database.
			}

			if(mysqli_query($link, $loginString)) {
				$updateString = "UPDATE tbl_user SET user_ip='{$ip}' WHERE user_id={$id}";
				$updateQuery = mysqli_query($link, $updateString);
			}

			if(mysqli_query($link, $loginString)){
				$newAttempts = "UPDATE tbl_user SET user_attempts = '0' WHERE user_name = '{$username}'";
				$newQuery = mysqli_query($link, $newAttempts); //This restores the attempts to 0 when properly logged in.
			}
			redirect_to("admin_index.php");
	}else{
		//$message = "Username/Password was incorrect. You now have x chances to get it right.";
		//return $message;
		$found_user = mysqli_fetch_array($user_attemptLock_query, MYSQLI_ASSOC);
		$attempts = $found_user['user_attempts'];
		$lockdate = $found_user['user_lockdate'];

		if($attempts>2){ //This is when the user is locked out, and tries again.
			$message = "I said you are locked out! ".(15 - floor((strtotime($datefix) - strtotime($lockdate))/60))." minutes until you can try again.";
			return $message;

		}else if($attempts>1){
			$newLockout = "UPDATE tbl_user SET user_lockdate = '$datefix' WHERE user_name = '{$username}'";
			$newQuery = mysqli_query($link, $newLockout); //This keeps track of the time that the user is officially locked out.

			$newAttempts = "UPDATE tbl_user SET user_attempts = user_attempts + 1 WHERE user_name = '{$username}'";
			$newQuery = mysqli_query($link, $newAttempts); // This adds the final attempt to the DB, making it 3.

			$message = "Look what you've done. Please wait 15 minutes before trying again"; //This is the message to go along with it.
			return $message;

		}else{ //Otherwise, just add 1 to the users attempt number in the database, when they only get the username correct.
			$newAttempts = "UPDATE tbl_user SET user_attempts = user_attempts + 1 WHERE user_name = '{$username}'";
			$newQuery = mysqli_query($link, $newAttempts);

			$message = "Uhhh.. Nope! That's not it. You have ".(2- $attempts)." attempt(s) remaining. Get it together!";
			return $message; //This message displays after the first & second wrong password attempt.
		}

	}

		mysqli_close($link);
	}

?>
