<?php
function recipeContent($msg, $recipe, $ingredients, $chef, $cooking_techniques, $food_categories, $dietary_prefs, $recipe_mean_rating, $nutritionist_approval, $nutritionist){
    ?>

<main>
        
    <!-- Recipe Page Main -->
    <div class="recipe-content_container">
        <? if ($msg) { ?>
            <label>
            <input type="checkbox" class="alertCheckbox" autocomplete="off" />
                <div class="alert notice">
                    <span class="alertClose">X</span>
                    <span class="alertText"><?php echo $msg; ?>
                    <br class="clear"/></span>
                </div>
            </label>
            <?php } ?>
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

<?php
}
?>