<?php
  require_once(__DIR__ . '/../views/header.php');
  require_once(__DIR__ . '/../views/footer.php');
  require_once(__DIR__ . '/../views/addRecipe.php');
  require_once(__DIR__ . '/../database/person.class.php'); 
 //TODO Associate plan with chef

  head("Add Recipe");
  recipeForm();
  footer();

?>
