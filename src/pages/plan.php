<?php
  require_once(__DIR__ . '/../views/footer.php');
  require_once(__DIR__ . '/../views/header.php');
  require_once(__DIR__ . '/../views/plans.php');
  require_once(__DIR__ . '/../database/weeklyPlan.class.php');

  $id = $_GET['id'];

  $plan = WeeklyPlan::getWeeklyPlan(intval($id));

  head("Plan"); //TODO: finish header 
  viewPlan($plan);
  footer();
?>

