<!-- recipe_page.php; INACABADA -->



<?php
    // Include necessary classes and retrieve recipe details
    require_once 'recipe.class.php';
    require_once 'ingredient_recipe.class.php';
    
    // Get recipe id from the URL or wherever you have it
    $recipeId = $_GET['recipe_id'] ?? 1; // gets the id from the url

    // Get recipe details
    $recipe = Recipe::getRecipeById($recipeId);
    $ingredients = IngredientRecipe::getIngredientsByRecipeId($recipeId);
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/layout.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0">
        <title>Recipe Page</title> <!-- ADAPTAR -->
    </head>

    <body>

        <header class="header">
                    <?php header(); ?>
        </header>

        <!-- Recipe Header Section -->
        <div class="recipe-practicalinfo">
            <h1><?php echo $recipe->name; ?></h1>
            <div class="recipe-details">
                <span class="detail">Time: <?php echo $recipe->preparation_time; ?> mins</span>
                <span class="detail">Difficulty: <?php echo $recipe->difficulty; ?></span>
                <span class="detail">Servings: <?php echo $recipe->number_of_servings; ?></span>
                <span class="detail">Rating: <?php echo $recipe->rating; ?></span>
            </div>
        </div>

        <!-- Recipe Photo Section -->
        <section class="recipe-photo">
            <img src="<?php echo $recipe->image; ?>" alt="<?php echo $recipe->name.' photo '; ?>">
        </section>

        <!-- Recipe Main Content Section -->
        <section class="recipe-content">

            <!-- Chef Info and Nutritionist Verification -->
            <div class="recipe-chef_info">
                <p>Chef: <?php echo $recipe->getChefName(); ?></p>
            </div>

            <div class="recipe-nutritionist_verified"> <!-- ver isto!!!! -->
            <?php if ($recipe->isNutritionistVerified): ?>
                    <p class="verified">Nutritionist Verified</p>
                <?php endif; ?>
            </div>

            <!-- Ingredients List -->
            <div class="recipe-ingredients">
                <h2>Ingredients</h2>
                <ul>
                    <?php foreach ($ingredients as $ingredient): ?>
                        <li><?php echo $ingredient->name . ' ' . $ingredient->quantity . ' ' . $ingredient->measurementUnit; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Preparation Method -->
            <div class="recipe-preparation">
                <h2>Preparation Method</h2>
                <p><?php echo $recipe->preparationMethod; ?></p>
            </div>

            <!-- Nutritional Info -->
            <div class="recipe-nutritional_info">
                <h2>Nutritional Information</h2>
                <div class="recipe-nutrient">
                    <span>Energy: <?php echo $recipe->energy; ?> kcal</span>
                    <span>Protein: <?php echo $recipe->protein; ?> g</span>
                    <span>Fat: <?php echo $recipe->fat; ?> g</span>
                    <span>Carbohydrates: <?php echo $recipe->carbohydrates; ?> g</span>
                </div>
            </div>

            <!-- Additional Info - Recipe Tags -->
            <div class="additional-info">
                <h2>Additional Information</h2>  <!-- ver nome melhor para aqui!!!!!! -->
                <div class="recipetag-item">Dietary Preferences: <?php echo $recipe->dietaryPreferences; ?></div>
                <div class="recipetag-item">Food Categories: <?php echo $recipe->foodCategories; ?></div>
                <div class="recipetag-item">Cooking Techniques: <?php echo $recipe->cookingTechniques; ?></div>
            </div>
        </section>

        <!-- Include your CSS file -->
    </body>
</html>