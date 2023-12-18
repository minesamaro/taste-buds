<?php
  require_once(__DIR__ . '/../views/footer.php');
  require_once(__DIR__ . '/../views/changeProfile.php');
  require_once(__DIR__ . '/../views/header.php');

 // Check if user is logged in, other wise redirect to 404 page
  if (!isset($_SESSION['user_id'])) {
         header("Location: ../pages/404.php");
     } else {
       head("Profile");
       changeProfile();
       footer();
     }
     ?>