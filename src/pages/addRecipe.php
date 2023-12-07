<?php
  require_once(__DIR__ . '/../views/footer.php');
  require_once(__DIR__ . '/../views/addRecipe.php');
  require_once(__DIR__ . '/../views/header.php');

 //TODO Associate plan with chef

  head("Add Recipe");
  recipeForm();
  footer();
?>
