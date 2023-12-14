<?php
  require_once(__DIR__ . '/../views/footer.php');
  require_once(__DIR__ . '/../views/changePassword.php');
  require_once(__DIR__ . '/../views/header.php');

 //TODO Associate plan with nutri

  head("Profile");
  changePassword();
  footer();
?>