<?php
  require_once(__DIR__ . '/../views/footer.php');
  require_once(__DIR__ . '/../views/header.php');
  require_once(__DIR__ . '/../views/profilePlans.php');
  require_once(__DIR__ . '/../database/weeklyPlan.class.php');
  require_once(__DIR__ . '/../database/commonUser.class.php');

   $id = $_GET['id'];
  // Check if user is logged in, and the plan corresponds to the user either as nutritionist or as common user
//   if (!isset($_SESSION['user_id']) || !WeeklyPlan::checkPlanUser(intval($id), $_SESSION['user_id'])) {
//          header("Location: ../pages/404.php");
//      }
//   else

  //$plan = WeeklyPlan::getWeeklyPlan(intval($id));

  head("Plans"); //TODO: finish header 
  profilePlans();
  footer();
?>

