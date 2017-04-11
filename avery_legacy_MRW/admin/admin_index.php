<?php
  ini_set('display_errors',1);
  error_reporting(E_ALL);
    require_once('phpscripts/init.php');
    //confirm_logged_in() //This is to protect the page.
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Admin Page 4 Only the Biggest Nickelback Fans</title>
    <link rel="stylesheet" href="css/main.css" />
    <link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
  </head>
  <body>
   <header>
    <h1 class="greeting">Oh! It's you again, <?php echo $_SESSION['users_fname']; ?>.</h1>
	</header>
   <section>
    <h2>Welcome back. You must really love Nickelback.</h2>
    <img src="../images/nickelback.png" alt="Band Photo" id="photo">
    <h3>The last time you logged in was <?php echo $_SESSION['users_date']; ?></h3>
	</section>
   <footer>
   		<nav>
   		<ul>
			<li><a href="admin_createuser.php">Create User</a></li>
			<li><a href="admin_edituser.php">Edit Your Account</a></li>
			<li><a href="phpscripts/caller.php?caller_id=logout">Sign Out</a></li>
			<li><a href="../index.php">Back Home</a></li>
	   </ul>
	   </nav>
	  </footer>
  </body>
</html>
