<?php
require_once(__DIR__ . '/../database/recipe.class.php');
session_start(); // Weird bug where session_start() has to be called first but only after the recipe class import
require_once(__DIR__ . '/../views/footer.php');
require_once(__DIR__ . '/../views/header.php');
require_once(__DIR__ . '/../views/recipeIndex.php');
require_once(__DIR__ . '/../views/sortRecipes.php');
require_once(__DIR__ . '/../views/filters.php');


//var_dump($_SESSION);

// If there is a cookie withthe recipes, use the recipes that match the filters
if (isset($_SESSION["recipes"])) {
    $recipes = $_SESSION["recipes"];
} else {
    $recipes = Recipe::getAllRecipes();
}

head("Recipes");
?>
<main class="indexBundle">
<?php 
filters(); 
sortRecipes();
recipeIndex($recipes);
?>
</main>
<?php
footer();
?>