<?php
  require_once(__DIR__ . '/../views/footer.php');
  require_once(__DIR__ . '/../views/changePassword.php');
  require_once(__DIR__ . '/../views/header.php');

 //TODO Associate plan with nutri
 if (isset($_SESSION['msg'])){
  $msg = $_SESSION['msg'];
  unset($_SESSION['msg']);
  }
  else {
      $msg = null;
  }

  head("Profile");
  changePassword($msg);
  footer();
?>