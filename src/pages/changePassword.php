<?php
  require_once(__DIR__ . '/../views/footer.php');
  require_once(__DIR__ . '/../views/changePassword.php');
  require_once(__DIR__ . '/../views/header.php');

 // Check if user is logged in, other wise redirect to 404 page
 if (!isset($_SESSION['user_id'])) {
  header("Location: ../pages/404.php");
} else {
head("Change Password");}
if (isset($_SESSION['msg'])){
  $msg = $_SESSION['msg'];
  unset($_SESSION['msg']);
  }
  else {
      $msg = null;
  }

  
  changePassword($msg);
  footer();


?>