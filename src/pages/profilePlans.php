<?php
  require_once(__DIR__ . '/../views/header.php');
  require_once(__DIR__ . '/../views/footer.php');
  require_once(__DIR__ . '/../views/profilePlans.php');
  require_once(__DIR__ . '/../database/weeklyPlan.class.php');
  require_once(__DIR__ . '/../database/commonUser.class.php');

  // Check if user is logged in, and the plan corresponds to the user either as nutritionist or as common user
   if (!isset($_SESSION['user_id'])) {
         header("Location: ../pages/404.php");
  } else{   
      head("Plans");
      profilePlans();
      footer();
      }
?>

