<?php
  require_once(__DIR__ . '/../views/footer.php');
  require_once(__DIR__ . '/../views/addPlan.php');
   
  head(); //TODO: finish header
  planForm();
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