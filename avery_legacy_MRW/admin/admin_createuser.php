<?php
	require_once("phpscripts/init.php");
	//confirm_logged_in();

	if(isset($_POST['submit'])) {
		//echo "works";
		$fname = trim($_POST['fname']);
		$lname = trim($_POST['lname']);
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		$email = trim($_POST['email']);
		$level = $_POST['lvllist'];
		if(empty($level)) {
			$message = "Please select a user level.";
		}else{
			//echo "all good";
			$result = createUser($fname, $lname, $username, $level, $email);
			$message = $result;
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Create New User</title>
	<link rel="stylesheet" href="css/main.css" />
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
	</head>
	<body>
		<h1>Create a User</h1>
		<?php if(!empty($message)){echo $message;} ?>
		<form action="admin_createuser.php" method="post">
<label>FIRST NAME</label><br>
<input type="text" name="fname" value="<?php if(!empty($fname)){echo $fname;} ?>"><br><br>
<label>LAST NAME</label><br>
<input type="text" name="lname" value="<?php if(!empty($lname)){echo $lname;} ?>"><br><br>
<label>USERNAME</label><br>
<input type="text" name="username" value="<?php if(!empty($username)){echo $username;} ?>"><br><br>
<!--<label>Password</label>
<input type="text" name="password" value="">-->
<label>E-MAIL</label><br>
<input type="text" name="email" value="<?php if(!empty($email)){echo $email;} ?>"><br>
<select name="lvllist">
	<option value="">Select a user level...</option>
	<option value="2">Web Admin</option>
	<option value="1">Web Master</option>
</select>
<br><br>
<input type="submit" class="submitButton" name="submit" value="CREATE USER">

		</form>
		<footer>
   		<nav>
   		<ul>
			<li><a href="admin_createuser.php">Create User</a></li>
			<li><a href="phpscripts/caller.php?caller_id=logout">Sign Out</a></li>
			<li><a href="../index.php">Back Home</a></li>
	   </ul>
	   </nav>
		</footer>

	</body>
</html>
