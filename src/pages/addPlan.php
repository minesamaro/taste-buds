<?php
  require_once(__DIR__ . '/../views/footer.php');
  require_once(__DIR__ . '/../views/addPlan.php');
  require_once(__DIR__ . '/../views/header.php');

 // Check if user is a nutritionist, other wise redirect to 404 page
 if (!isset($_SESSION['user_id']) || !Person::isNutritionist($_SESSION['user_id'])) {
        header("Location: ../pages/404.php");
    } else {
      head("Add Plan");
      planForm();
      footer();
    }
    ?>
