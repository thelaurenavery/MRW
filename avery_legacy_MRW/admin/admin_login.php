<?php
	ini_set('display_errors', 1);
	error_reporting(E_ALL); /*If you have a pc, it runs automatically*/
	$ip = $_SERVER["REMOTE_ADDR"];
	//echo $ip;

	require_once("phpscripts/init.php"); /*This is to gain access to this file*/

	if(isset($_POST['submit'])) {
		/*echo "God DAMN it you are good at clickin.";*/
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);

		if($username != "" && $password != "") { //&& means BOTH/AND
			$result = logIn($username, $password, $ip);
			$message = $result;

		}else{
			$message = "Aren't you forgetting something?";
		}
	}
?>

<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Research Assignment 2 - CMS LOGIN/CREATE USER</title>
<link rel="stylesheet" href="css/main.css" />
<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
</head>

<body>
	<header>
	<h1>Hey, hi and hello!</h1>
	</header>
	<section>
		<h2>Admin Login Page</h2>
	<p>You found our secret fanclub. If you'd like to 100% confirm that you are a massive Nickelback fan, please login below!</p><br>
	<?php if(!empty($message)) {echo $message;} ?>
		<form action="admin_login.php" method="post">
			<label class="spaces">USERNAME</label><br>
			<input type="text" name="username" value=""><br><br>
			<label class="spaces">PASSWORD</label><br>
			<input type="password" name="password" value=""><br><br>
			<input class="spaces submitButton" type="submit" name="submit" value="OK GO">
	</form>
	</section>
	<footer><br><br>
	   		<nav>
  
			<a href="../index.php">Back Home</a>
	   
	   </nav>
	</footer>
</body>
</html>
