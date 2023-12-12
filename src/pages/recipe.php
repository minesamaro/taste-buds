<?php
 session_start();
 
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
    require_once(__DIR__ . '/../actions/action_write_recipe_rating.php');

    
    
    if (isset($_SESSION['msg'])){
        $msg = $_SESSION['msg'];
        unset($_SESSION['msg']);
        echo $msg;
    }
    else {
        $msg = null;
    }
    

    
    // Get recipe id from the URL or wherever you have it
    $recipeId = $_GET['recipe_id'] ?? 1; // gets the id from the url
    $userId = $_SESSION['user_id'] ?? 1; // gets the id from the session
    $session_user = Person::getPersonById($userId);


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
    $ratings=RecipeRating::getRecentRatingsForRecipe($recipeId);


head($recipe->name);
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

        <section class="recipe-ratings">

            <div class="recipe-write_rating">
                <h2 id="recipe-write_rating_title">Rate this recipe</h2>
            
                <form id="recipe_write_rating" action="../actions/action_write_recipe_rating.php" method="post"> 
                    <div class="recipe-rating_username"> <? echo $session_user->username; ?> </div>

                    <div class="form-group" id="form-recipe_rating_value">
                    <label>Rating:
                        <input type="n" id="recipe-write_rating_value" name="recipe-write_rating_value" min="0" max="5" step="1" required>        
                    </label>

                    <div class="form-group" id="form-recipe_rating_comment">
                        <input type="text" id="recipe-write_rating_comment" name="recipe-write_rating_comment" placeholder="Write your comment here...">       
                    </div>

                    <button>Submit rating</button>
                </form>
            </div>

            <div class="recipe-see_ratings">
                <h2 id="recipe-see_ratings_title">Ratings from other users</h2>
                
                <?php foreach ($ratings as $rt) { 
                    $rating_user=Person::getPersonById($rt->userId); ?>
                    <!-- meter aqui profile photo -->
                    <span class="recipe-rating_username"> <? echo $rating_user->username; ?> </span>
                    <span class="recipe-rating_date"> <? echo $rt->ratingDate; ?> </span>
                    <span class="recipe-rating_value"> <? echo $rt->ratingValue; ?> </span> <!-- meter dps com estrelinhas -->
                    <span class="recipe-rating_comment"> <? echo $rt->comment; ?> </span>
                <? } ?>
            </div>

            <form id="recipe_all_ratings" action="../actions/action_all_recipe_ratings.php"> <!-- fazemos um mini form que é só o botão para log out, vamos ter que criar o ficheiro action_logout.php -->
                <button>See all ratings</button>
            </form>
        
        </section>

    </div>
</body>
</html>