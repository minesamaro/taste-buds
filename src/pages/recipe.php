<?php
    // Include necessary classes and retrieve recipe details
    require_once(__DIR__ . '/../views/header.php');
    require_once(__DIR__ . '/../views/footer.php');
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

    head($recipe->name);
?>

    
<body>
    <main>

    <!-- Recipe Page Main -->
    <div class="recipe-content_container">

        <!-- Recipe Header Section - general info -->
        <section class="recipe-initial_info">

            <!-- Title -->
            <div class="recipe-title">
                <h1 id="recipe-title"><?php echo $recipe->name; ?></h1>
            </div>

            <!-- General Info -->
            <span class= "recipe-details" id="recipe-detail_time">Time: <?php echo $recipe->preparationTime; ?> min</span>
            <span class= "recipe-details" id="recipe-detail_difficulty">Difficulty: <?php echo $recipe->difficulty; ?> / 5</span>
            <span class= "recipe-details" id="recipe-detail_serving">Servings: <?php echo $recipe->numberOfServings; ?></span>
            <span class= "recipe-details" id="recipe-detail_rating">Rating: 
                <?php            
                    if ($recipe_mean_rating == 0) {
                        echo "No ratings yet";
                    } else {
                        echo $recipe_mean_rating;
                    }
                ?>
            </span>
            
            

            <!-- Recipe Photo Section -->
            <div class="recipe-photo">
                <img src="<?php echo $recipe->image; ?>" alt="<?php echo $recipe->name.' photo '; ?>">
                </div>

            <!-- Chef Info and Nutritionist Verification -->
            <span class="recipe-chef_submission_info">
                <p><?php
                // Get link to chef profile
                $chef_profile_link = '../pages/profile.php?person_id=' . $chef->id;
                echo '<a href="' . $chef_profile_link . '"> Chef '. $chef->first_name . ' ' . $chef->surname . '</a>';
                echo ' on ' . (new DateTime($recipe->submissionDate))->format('d-m-Y'); 
                ?></p>
            </span>

            <span class="recipe-nutritionist_verified"> <!-- ver isto!!!! -->
            <?php
                if ($nutritionist_approval) {
                    $nutritionist_profile_link = '../pages/profile.php?person_id=' . $nutritionist->id;
                    echo 'Verified by <a href="' . $nutritionist_profile_link . '">  Nutritionist '.  $nutritionist->first_name. ' ' . $nutritionist->surname . '</a>';
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
                        <li class="recipe-ingredient arrow">
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

        <!-- Final Details - tags, nutri  info -->
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
            
            <div class="recipe-tags card-categories">
                
               
                <!-- Cooking Techniques -->
                <div class="recipe-tag_item category">
                    <p>Cooking Techniques:</p>
                    <?php foreach ($cooking_techniques as $ct) {
                        echo "<h6>";
                        echo $ct->cookingTechnique . '<br>';
                        echo "</h6>";
                    } ?>
                </div>

                <!-- Food Categories -->
                <div class="recipe-tag_item category">
                    <p>Food Categories:</p>
                    <?php foreach ($food_categories as $fc) {
                        echo "<h6>";
                        echo $fc->category . '<br>';
                        echo "</h6>";
                    } ?>
                </div>

                <!-- Dietary Preferences -->
                <div class="recipe-tag_item category">
                    <p>Dietary Preferences:</p>
                    <?php foreach ($dietary_prefs as $dp) {
                        echo "<h6>";
                        echo $dp->dietaryPref . '<br>';
                        echo "</h6>";
                    } ?>
                 </div>

            </div>
        </section>
 
        <!-- Ratings Section -->
        <section class="recipe-ratings">
            
            <h2 id="recipe-see_ratings_title">Ratings (<?php
                if ($all_ratings) { 
                    echo count($all_ratings); 
                } else {
                    echo 0;
                } ?>)</h2>

                

            <?php if($userId) { ?>

                <div class="recipe-see_ratings">
                                
                <?php foreach ($ratings as $rt) { 
                    $rating_user=Person::getPersonById($rt->userId); ?>
                    <div class="card">
                        <!-- meter aqui profile photo -->
                        <div class="rating-top">
                            <a id="rating-name" href="../pages/profile.php?person_id=<?php echo $rating_user->id; ?>"><? echo $rating_user->first_name . " " . $rating_user->surname; ?></a>
                            <div class="rating-stars">
                                <?php for ($i = 0; $i < $rt->ratingValue; $i++) { ?>
                                    <span class="">&#x2605</span>
                                <?php } 
                                for ($i = 0; $i < 5 - $rt->ratingValue; $i++) { ?>
                                    <span class="">&#x2606</span>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="rating-bottom">
                            <span class="recipe-rating_username"> <? echo $rating_user->username; ?> </span>
                            <span class="recipe-rating_date"> <? echo $rt->ratingDate; ?> </span>
                        </div>
                        <div class="rating-comment">
                            <span class="recipe-rating_comment"> <? echo $rt->comment; ?> </span>
                        </div>
                    </div>
                <? } 
                if ($ratings) {?>
                <a id="recipe_all_ratings" href="../pages/allRecipeRatings.php"><button>See all ratings</button></a> 
                <?php }

                if(!$ratings) {
                    echo "No ratings yet";
                } ?>

                </div>

                <?php if (!RecipeRating::checkUserRecipeRating($userId, $recipeId)) { ?>
                <div class="recipe-write_rating">
                    <h2 id="recipe-write_rating_title">Rate this recipe</h2>
                    <div class="card">
                        <form id="recipe_write_rating" action="../actions/action_write_recipe_rating.php" method="post"> 
                            <div id="rating-name"> <? echo $session_user->first_name . " " . $session_user->surname; ?> </div>

                            <div class="form-group" id="form-recipe_rating">
                            <fieldset class="star-rating">
                                <input checked name="recipe-write_rating_value" value="0" type="radio" id="rating0">
                                <label for="rating0">
                                    <span class="hide-visually">0 Stars</span>
                                </label>

                                <input name="recipe-write_rating_value" value="1" type="radio" id="rating1">
                                <label for="rating1">
                                    <span class="hide-visually">1 Star</span>
                                    <span aria-hidden="true" class="star">★</span>
                                </label>

                                <input name="recipe-write_rating_value" value="2" type="radio" id="rating2">
                                <label for="rating2">
                                    <span class="hide-visually">2 Stars</span>
                                    <span aria-hidden="true" class="star">★</span>
                                </label>

                                <input name="recipe-write_rating_value" value="3" type="radio" id="rating3">
                                <label for="rating3">
                                    <span class="hide-visually">3 Stars</span>
                                    <span aria-hidden="true" class="star">★</span>
                                </label>

                                <input name="recipe-write_rating_value" value="4" type="radio" id="rating4">
                                <label for="rating4">
                                    <span class="hide-visually">4 Stars</span>
                                    <span aria-hidden="true" class="star">★</span>
                                </label>

                                <input name="recipe-write_rating_value" value="5" type="radio" id="rating5">
                                <label for="rating5">
                                    <span class="hide-visually">5 Stars</span>
                                    <span aria-hidden="true" class="star">★</span>
                                </label>
                            </fieldset>
                            </div>

                            <div class="form-group" id="form-recipe_rating_comment">
                                <!-- create a text area for comments -->
                                <textarea class="card-small" id="recipe-write_rating_comment" name="recipe-write_rating_comment" placeholder="Write your comment here..." cols="30" rows="5"></textarea>
                            </div>

                            <button>Submit rating</button>
                        </form>
                    </div>
                </div>
            <?php }} else {
                echo "Log in to rate this recipe";
            }

           /*  else { ?>

                <div class="recipe-already_user_rated">
                    <h2 id="recipe-already_user_rated_title">Your rating for this recipe</h2>

                    <?php $session_user_rating=RecipeRating::getRecipeRatingByRecipeAndUser($recipeId, $userId); ?>

                    <span class="recipe-rating_username"> <? echo $session_user->username; ?> </span>
                    <span class="recipe-rating_date"> <? echo $session_user_rating->ratingDate; ?> </span>
                    <span class="recipe-rating_value"> <? echo $session_user_rating->ratingValue; ?> </span> 
                    <span class="recipe-rating_comment"> <? echo $session_user_rating->comment; ?> </span>

                </div>
            <?php } ?> */ ?>
        
        </section>

    </div>
<?php
footer();
?> 