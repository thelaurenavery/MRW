<?php
	require_once("phpscripts/init.php");
	//confirm_logged_in();

	ini_set('display_errors',1);
	error_reporting(E_ALL);

	$id = $_SESSION['users_creds'];
	$popForm = getUser($id);

	if(isset($_POST['submit'])) {
		//echo "works";
		$fname = trim($_POST['fname']);
		$lname = trim($_POST['lname']);
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);
		
		$result = editUser($id, $fname, $lname, $username, $password);
		$message = $result;
		
	}
?>

<!DOCTYPE html>
<html>
	<head>
<meta charset="utf-8">
<title>Edit Your Account</title>
<link rel="stylesheet" href="css/main.css" />
<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
	</head>
	<body>
		<h1>Edit User</h1>
		<?php if(!empty($message)){echo $message;} ?>
		
		<form action="admin_edituser.php" method="post">
<label>FIRST NAME</label><br>
<input type="text" name="fname" value="<?php echo $popForm['user_fname'];?>"><br><br>
<label>LAST NAME</label><br>
<input type="text" name="lname" value="<?php echo $popForm['user_lname'];?>"><br><br>
<label>USERNAME</label><br>
<input type="text" name="username" value="<?php echo $popForm['user_name'];?>"><br><br>
<label>PASSWORD</label><br>
<input type="text" name="password" value="<?php echo $popForm['user_pass'];?>"><br><br>
<br>
<input type="submit" class="submitButton" name="submit" value="EDIT ACCOUNT">
		</form>
		
		<footer>
		<nav>
   		<ul>
			<li><a href="phpscripts/caller.php?caller_id=logout">Sign Out</a></li>
			<li><a href="../index.php">Back Home</a></li>
	   </ul>
	   </nav>
		</footer>

	</body>
</html>
