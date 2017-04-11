<?php
  	function createUser($fname, $lname, $username, $level, $email) {
    require_once("connect.php"); //be careful with using includes
	$password = bin2hex(openssl_random_pseudo_bytes(3)); //this randomly generates a password, the number indicates half the length it will be. This only uses 0-9 / a-f in lowercase. BINARY = 1's and 0's converts it to letters # x 2
    $ip = 0;
	$date = new dateTime();
	$datefix = $date -> format('Y-m-d H:i:s');
    $userstring = "INSERT INTO tbl_user VALUES(NULL,'{$fname}','{$lname}','{$username}','{$password}','{$level}','{$ip}','1000-01-01 00:00:00','1000-01-01 00:00:00','0','{$email}','no','$datefix')"; // added 'no' to indicate user has not edited their account. The date to track when the email was sent, so it expires.
    //echo $userstring;
	$emailmsg = "Hello and thanks for signing up! Your username is {$username} and your password is {$password}.\n You may edit your account details once you are logged in. \n\n To login click here: http://localhost/mmed_3014_r1/admin/admin_login.php"; //this is the messgae which would be emailed to the user if it were live on a domain. the \n acts as a line break so the message is easier to read/formatted better.
	  
    $userquery = mysqli_query($link, $userstring); //The actual creating of the user
    if($userquery){ //if it runs and is successful, run the "mail" function premade already in php -
		mail('{$email}', "Your company email and password.",$emailmsg); //it must be in this order so that the email feild, subject line, and message are entered in the correct fields
      redirect_to("admin_index.php"); //when email is sent/function is complete, redirect to admin index page
    }else{
      $message = "Your hiring practices have failed you, we can not keep this individual.";
		echo $password;
      return $message;
    }
    mysqli_close($link);
  }
	  
	 function getUser($id) {
		 require_once("connect.php");
		 $userstring = "SELECT * FROM tbl_user WHERE user_id={$id}";
		$userquery = mysqli_query($link, $userstring);
		 if($userquery){
			  $found_user = mysqli_fetch_array($userquery, MYSQLI_ASSOC);
			 return $found_user;
	 }else{
		 $message = "There was a prob wit ur account baiii!";
		 
		 return $message;
	 }
		  
		 mysqli_close($link);
	 }
		 function editUser($id, $fname, $lname, $username, $password){
			 include("connect.php");
			 $updatestring = "UPDATE tbl_user SET user_fname ='{$fname}',user_lname ='{$lname}',user_name ='{$username}',user_pass ='{$password}',user_email = '{$email}', user_edited = 'yes' WHERE user_id = {$id}";
			 
			 $updatequery = mysqli_query($link, $updatestring);
			 
			 if($updatequery) {
			 	redirect_to("admin_index.php");
				}else{
				$message = "Not gonna happen";
				return $message;
				}
			 
			 
			 mysqli_close($link);
		 }
			//create query
		 //run query
		 //gather object, fetch array
		 //return
		 //else
		 //error message
		 //return
	
	 
  
?>
