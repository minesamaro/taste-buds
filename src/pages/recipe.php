<!-- recipe_page.php; INACABADA -->



<?php
    // Include necessary classes and retrieve recipe details
    require_once(__DIR__ . '/../views/footer.php');
    require_once(__DIR__ . '/../views/header.php');
    require_once (__DIR__ . '/../database/recipe.class.php');
    require_once (__DIR__ . '/../database/person.class.php');
    require_once (__DIR__ . '/../database/nutritionist.class.php');
    require_once (__DIR__ . '/../database/ingredient_recipe.class.php');
    require_once (__DIR__ . '/../database/recipe_cooktechn.class.php');
    require_once (__DIR__ . '/../database/recipe_category.class.php');
    require_once (__DIR__ . '/../database/recipe_dietarypref.class.php');
    require_once(__DIR__ . '/../database/recipe_rating.class.php');
    require_once(__DIR__ . '/../database/nutritionist_approval.class.php');
    
    // Get recipe id from the URL or wherever you have it
    $recipeId = $_GET['recipe_id'] ?? 1; // gets the id from the url

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


head("Recipe");
?>

<!DOCTYPE html>
<html lang="en">
    

    <body>

        <!-- Recipe Header Section -->
        <div class="recipe-practicalinfo">
            <h1><?php echo $recipe->name; ?></h1>
            <div class="recipe-details">
                <span class="recipe-detail_item">Time: <?php echo $recipe->preparationTime; ?> min</span>
                <span class="recipe-detail_item">Difficulty: <?php echo $recipe->difficulty; ?></span>
                <span class="recipe-detail_item">Servings: <?php echo $recipe->numberOfServings; ?></span>
                <span class="recipe-detail_item">Rating: 
                    <?php            
                        if ($recipe_mean_rating == 0) {
                            echo "There are no ratings for this recipe yet.";
                        } else {
                            echo $recipe_mean_ratings;
                        }
                    ?>
                </span>
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
                <p>Chef: <?php echo $chef->first_name . ' ' . $chef->surname; ?></p>
            </div>

            <div class="recipe-submission_date">
                <p><?php echo 'Published on ' . (new DateTime($recipe->submissionDate))->format('d-m-Y'); ?></p>
            </div>

            <div class="recipe-nutritionist_verified"> <!-- ver isto!!!! -->
            <?php
                if ($nutritionist_approval) {
                    echo 'Verified by Nutritionist ' . $nutritionist->first_name . ' ' . $nutritionist->surname . ' on ' . (new DateTime($nutritionist_approval->approval_date))->format('d-m-Y');
                        } else {
                            echo 'Not Nutritionist Verified';
                        }
                    ?>

            <!-- Ingredients List -->
            <div class="recipe-ingredients">
                <h2>Ingredients</h2>
                <ul>
                    <?php foreach ($ingredients as $i): ?>
                        <li><?php echo $i->ingredient->name . ' ' . $i->quantity . ' ' . $i->measurementUnit; ?></li>
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
               
                <!-- Cooking Techniques -->
                <div class="recipe-tag_item">Cooking Techniques:
                    <?php foreach ($cooking_techniques as $ct) {
                        echo $ct->cookingTechnique . '<br>';
                    } ?>
                </div>

                <!-- Food Categories -->
                <div class="recipetag-item">Food Categories:
                    <?php foreach ($food_categories as $fc) {
                        echo $fc->category . '<br>';
                    } ?>
                </div>

                <!-- Dietary Preferences -->
                <div class="recipetag-item">Dietary Preferences:
                    <?php foreach ($dietary_prefs as $dp) {
                        echo $dp->dietaryPref . '<br>';
                    } ?>
                 </div>

            </div>
        </section>

        <!-- Include your CSS file -->
    </body>
</html>