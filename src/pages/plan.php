<?php declare(strict_types = 1); ?>

<?php
  require_once(__DIR__ . '/../database/weeklyPlan.class.php');

  $id = $_GET['id'];

  $plan = WeeklyPlan::getWeeklyPlan(intval($id));

    echo json_encode($plan);
?>

