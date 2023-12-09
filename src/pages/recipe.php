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

    <div class="recipe-content_container">

        <section class="recipe-initial_info">

            <!-- Recipe Header Section -->
            <div class="recipe-title">
                <h1 id="recipe-title"><?php echo $recipe->name; ?></h1>
            </div>

            <span id="recipe-detail_time">Time: <?php echo $recipe->preparationTime; ?> min</span>
            <span id="recipe-detail_difficulty">Difficulty: <?php echo $recipe->difficulty; ?></span>
            <span id="recipe-detail_serving">Servings: <?php echo $recipe->numberOfServings; ?></span>
            <span id="recipe-detail_rating">Rating: 
                <?php            
                    if ($recipe_mean_rating == 0) {
                        echo "No ratings yet";
                    } else {
                        echo $recipe_mean_ratings;
                    }
                ?>
            </span>
            
            

            <!-- Recipe Photo Section -->
            <div class="recipe-photo">
                <img src="<?php echo $recipe->image; ?>" alt="<?php echo $recipe->name.' photo '; ?>">
                </div>

            <!-- Chef Info and Nutritionist Verification -->
            <span class="recipe-chef_submission_info">
                <p><?php echo 'By Chef ' . $chef->first_name . ' ' . $chef->surname . ' on ' . (new DateTime($recipe->submissionDate))->format('d-m-Y'); ?></p>
            </span>

            <span class="recipe-nutritionist_verified"> <!-- ver isto!!!! -->
            <?php
                if ($nutritionist_approval) {
                    echo 'Verified by Nutritionist ' . $nutritionist->first_name . ' ' . $nutritionist->surname;
                } else {
                    echo 'Not Nutritionist Verified';
                }
            ?>
            </span>

        </section>

        <!-- Recipe Main Content Section -->
        <section class="recipe-main_content">

            <!-- Ingredients List -->
            <h2 id="recipe-ingredients_title">Ingredients</h2>
            <aside class="recipe-ingredients">
                <ul>
                    <?php foreach ($ingredients as $ig) { ?>
                        <li class="recipe-ingredient">
                            <span class="ingredient-name"><?php echo $ig->ingredient->name; ?></span>
                            <span class="ingredient-quantity"><?php echo $ig->quantity . ' ' . $ig->measurementUnit; ?></span>
                        </li>
                    <?php } ; ?>
                </ul>
                    </aside>

            <!-- Preparation Method -->
            <h2 id="recipe-preparation_title">Preparation</h2>
            <div class="recipe-preparation">
                
                <p><?php echo $recipe->preparationMethod; ?></p>
            </div>

        </section>

        <section class="recipe-final_info">

            <!-- Nutritional Info -->
            <h2 id="recipe-nutri_info_title">Nutritional Information</h2>

            <div class="recipe-nutritional_info">
                <div class="recipe-nutrient">
                    <div class="nutrient-item" id="recipe-energy">
                        <span class="nutrient-label">Energy:</span>
                        <span class="vnutrient-alue"><?php echo $recipe->energy; ?> kcal</span>
                    </div>
                    <div class="nutrient-item" id="recipe-protein">
                        <span class="nutrient-label">Protein:</span>
                        <span class="nutrient-value"><?php echo $recipe->protein; ?> g</span>
                    </div>
                    <div class="nutrient-item" id="recipe-fat">
                        <span class="nutrient-label">Fat:</span>
                        <span class="nutrient-value"><?php echo $recipe->fat; ?> g</span>
                    </div>
                    <div class="nutrient-item" id="recipe-carbs">
                        <span class="nutrient-label">Carbohydrates:</span>
                        <span class="nutrient-value"><?php echo $recipe->carbohydrates; ?> g</span>
                    </div>
                </div>
            </div>

            <!-- Additional Info - Recipe Tags -->
            <h2 id="recipe-tags_title">Tags</h2>  <!-- ver nome melhor para aqui!!!!!! -->
            
            <div class="recipe-tags">
                
               
                <!-- Cooking Techniques -->
                <div class="recipe-tag_item">Cooking Techniques:
                    <?php foreach ($cooking_techniques as $ct) {
                        echo $ct->cookingTechnique . '<br>';
                    } ?>
                </div>

                <!-- Food Categories -->
                <div class="recipe-tag_item">Food Categories:
                    <?php foreach ($food_categories as $fc) {
                        echo $fc->category . '<br>';
                    } ?>
                </div>

                <!-- Dietary Preferences -->
                <div class="recipe-tag_item">Dietary Preferences:
                    <?php foreach ($dietary_prefs as $dp) {
                        echo $dp->dietaryPref . '<br>';
                    } ?>
                 </div>

            </div>
        </section>

    </div>

        <!-- Include your CSS file -->
    </body>
</html>