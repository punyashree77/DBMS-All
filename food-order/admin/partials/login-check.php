<?php
  //Autorization or access control
  //check whether the user is logged in or not
  if(!isset($_SESSION['user']))//if user session is not set
  {
    //user is not logged in
    //redirct to login page
    $_SESSION ['no-login-message']="<div class='error text-center'> Please login to access admin panel</div>";

    //redirect to login page
    header('location:'.SITEURL.'admin/login.php');
  }