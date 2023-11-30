<?php
  require_once(__DIR__ . '/../views/footer.php');
  require_once(__DIR__ . '/../views/plans.php');
  require_once(__DIR__ . '/../database/weeklyPlan.class.php');

  $id = $_GET['id'];

  $plan = WeeklyPlan::getWeeklyPlan(intval($id));

  head(); //TODO: finish header 
  viewPlan($plan);
  footer();
?>

<?php 
function head() {
?>
  <!DOCTYPE html>
  <html lang="en">
    <head>
      <meta charset="UTF-8">
      <title>Plan</title>
      <link rel="stylesheet" href="../css/style.css">
      <link rel="stylesheet" href="../css/layout.css">
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    </head>
    <body>
      <?php
}

?>