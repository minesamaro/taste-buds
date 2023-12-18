<?php
  require_once(__DIR__ . '/../views/header.php');
  require_once(__DIR__ . '/../views/footer.php');
  require_once(__DIR__ . '/../views/addRecipe.php');
  require_once(__DIR__ . '/../database/person.class.php'); 
 //TODO Associate plan with chef
// Check if user is loggged in and is a chef, other wise redirect to 404 page
  if (!isset($_SESSION['user_id']) || !Person::isChef($_SESSION['user_id'])) {
         header("Location: ../pages/404.php");
     } else {
       head("Add Recipe");
       recipeForm();
       footer();
     }
?>
