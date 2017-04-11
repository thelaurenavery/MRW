<?php
  session_start();
  // 2 functions. 1 to check if someone has logged in/check sessions/kick you out
  //1 to sign out
  function confirm_logged_in() {
    if(!isset($_SESSION['users_creds'])){
      redirect_to("admin_login.php");
    }
  }

  function logged_out(){
    session_destroy();
    redirect_to("../admin_login.php");
  }
 ?>
