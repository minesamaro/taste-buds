<?php
  require_once(__DIR__ . '/../views/footer.php');
  require_once(__DIR__ . '/../views/changeProfile.php');
  require_once(__DIR__ . '/../views/header.php');

 //TODO Associate plan with nutri

  head("Profile");
  changeProfile();
  footer();
?>