<?php
require_once(__DIR__ . '/../views/header.php');
require_once(__DIR__ . '/../views/footer.php');
require_once(__DIR__ . '/../views/addRecipeIngredient.php');
require_once(__DIR__ . '/../views/recipeState.php');
require_once(__DIR__ . '/../database/recipe.class.php');
require_once(__DIR__ . '/../database/ingredient_recipe.class.php');
require_once(__DIR__ . '/../database/ingredient.class.php');


if (!isset($_SESSION['recipeId']) || !isset($_SESSION['user_id']) || !Recipe::isAuthor($_SESSION['recipeId'], $_SESSION['user_id'])) {
    //header("Location: ../pages/404.php");
} else {
    $recipe = Recipe::getRecipeById($_SESSION['recipeId']);
    $ingredients = Ingredient::getAllIngredients();

    head("Add Ingredients");
    ?>
    <main class="planBundle">
    <?php
        addRecipeIngredient($ingredients, $_SESSION['recipeId']);
        showRecipeState($recipe);
    ?>
    </main>
    <?php
    footer();
}
?>