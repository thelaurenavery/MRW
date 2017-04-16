<?php
//echo "From functions.php";

	function redirect_to($location) {
		if($location !=NULL){
			header("Location: {$location}");
			exit;
		}
	}

	function sendMessage($name, $email, $company, $message,$direct){
		$to = "email@stuff.com";
		$subject = "Message from mysite.com";
		$extra = "Reply to: {$email}";
		$body = "Name: {$name}\n\n Email: {$email}\n\n Company: {$company}\n\n Message: {$message} {$extra}";
		//echo $body;

		//This will not work on mamp/wamp...Put on actual server to check
		//mail($to,$subject,$body,$extra);
		//.............................

		redirect_to($direct);
	}


	
?>