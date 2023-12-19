<?php
    // Include necessary classes and retrieve recipe details
    require_once(__DIR__ . '/../views/header.php');
    require_once(__DIR__ . '/../views/footer.php');
    require_once (__DIR__ . '/../views/recipeContent.php');
    require_once (__DIR__ . '/../views/recipeRatings.php');
    require_once (__DIR__ . '/../database/recipe.class.php');
    require_once (__DIR__ . '/../database/person.class.php');
    require_once (__DIR__ . '/../database/nutritionist.class.php');
    require_once (__DIR__ . '/../database/ingredient_recipe.class.php');
    require_once (__DIR__ . '/../database/recipe_cooktechn.class.php');
    require_once (__DIR__ . '/../database/recipe_category.class.php');
    require_once (__DIR__ . '/../database/recipe_dietarypref.class.php');
    require_once(__DIR__ . '/../database/recipe_rating.class.php');
    require_once(__DIR__ . '/../database/nutritionist_approval.class.php');
    
    // messages - ex. when a person submits a rating
    $msg = $null;
    if (isset($_SESSION['msg'])){
        $msg = $_SESSION['msg'];
        unset($_SESSION['msg']);
    }
    else {
        $msg = null;
    }
    
    // Get recipe id from the URL or wherever you have it
    $recipeId = $_GET['recipe_id'] ?? 1; // gets the id from the url
    $userId = $_SESSION['user_id'] ?? null; // gets the id from the session

    // Will be used later for checking whether user (if logged in) has commented
    if ($userId) {
        $session_user = Person::getPersonById($userId);
    }

    // Get recipe details
    $recipe = Recipe::getRecipeById($recipeId);
    $ingredients = IngredientRecipe::getIngredientsForRecipe($recipeId);
    $chef=Person::getPersonById($recipe->idChef);
    $cooking_techniques=RecipeCookingTechnique::getRecipeCookingTechniques($recipeId);
    $food_categories=RecipeFoodCategory::getRecipeFoodCategories($recipeId);
    $dietary_prefs=RecipeDietaryPref::getRecipeDietaryPreferences($recipeId);
    $recipe_mean_rating=RecipeRating::getMeanRatingForRecipe($recipeId);
    $nutritionist_approval = NutritionistApproval::getNutritionistApprovalForRecipe($recipeId);
    if($nutritionist_approval) {
        $nutritionist=Person::getPersonById($nutritionist_approval->nutritionist_id);
    }

    // Get most recent ratings and count all the ratings for the specific recipe
    $ratings=RecipeRating::getRecentRatingsForRecipe($recipeId, $userId);
    $all_ratings = RecipeRating::getRecipeRatingsByRecipeId($recipeId, $userId);

    // Display the page

    head($recipe->name);
    recipeContent($msg, $recipe, $ingredients, $chef, $cooking_techniques, $food_categories, $dietary_prefs, $recipe_mean_rating, $nutritionist_approval, $nutritionist);
    recipeRatings($ratings, $all_ratings, $userId, $session_user, $recipeId);
    footer();
?> 