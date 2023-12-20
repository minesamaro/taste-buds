<?php
  require_once(__DIR__ . '/../views/footer.php');
  require_once(__DIR__ . '/../views/profile.php');
  require_once(__DIR__ . '/../views/header.php');

 if (!isset($_SESSION['user_id'])) {
    header('Location: ../pages/login.php');
  }else{  
    head("Profile");
    Profile();
    footer();
  }
?>