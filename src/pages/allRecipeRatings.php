<?php
require_once(__DIR__ . '/../views/header.php');
require_once(__DIR__ . '/../views/footer.php');
require_once(__DIR__ . '/../views/allrecipeRatings.php');
require_once(__DIR__ . '/../database/recipe_rating.class.php');
require_once(__DIR__ . '/../database/recipe.class.php');

// Everyone can see the ratings of a recipe, so no permissions are needed

// Only if logged in can see the page

if (!isset($_SESSION['user_id'])) {
    header("Location: ../pages/404.php");
} else {
    // Retrieve recipe ID from the URL
    $recipeId = $_GET['recipe_id'] ?? 1; //change this, is to choose a recipe for now
    $recipe = Recipe::getRecipeById($recipeId);
    $userId = $_SESSION['user_id'] ?? null; 

    // Retrieve all ratings for the specified recipe
    $ratings = RecipeRating::getRecipeRatingsByRecipeId($recipeId, $userId);

    head($recipe->name . ': All Ratings');
    allrecipeRatings($ratings, $recipe);
    footer();
}
?>
