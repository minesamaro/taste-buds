<?php
require_once(__DIR__ . '/../database/recipe.category.class.php');
require_once(__DIR__ . '/../database/cooking.technique.class.php');

function sortRecipes()
{
    // Check if there are selected categories, techniques, and preferences
    $selectedCategories = isset($_SESSION['selectedCategories']) ? $_SESSION['selectedCategories'] : [];
    $selectedTechniques = isset($_SESSION['selectedTechniques']) ? $_SESSION['selectedTechniques'] : [];
    $selectedPreferences = isset($_SESSION['selectedPreferences']) ? $_SESSION['selectedPreferences'] : [];
    $_SESSION['orderBy'] = isset($_SESSION['orderBy']) ? $_SESSION['orderBy'] : 'recent';
    ?>
<div item="sort">

<form action="../actions/actionClearFilters.php" method="POST">
    <button type="submit">Clear Filters</button>
</form>

<form action="../actions/actionFilterIndex.php" method="POST">
    <button type="submit">Filter</button>
    <div class="filter-block order">
        <h4>Order By</h4>
                    <div class="radio-wrapper">
                        <input class="radio-btn" id="recent" type="radio" name="order" value="recent" <?php echo ($_SESSION['orderBy'] == 'recent') ? 'checked' : ''; ?>>
                        <label for="recent" class="label">Most Recent</label>
                    </div>
                    <div class="radio-wrapper">
                        <input class="radio-btn" id="bestScore" type="radio" name="order" value="review" <?php echo ($_SESSION['orderBy'] == 'review') ? 'checked' : ''; ?>>
                        <label for="bestScore" class="label">Best Reviews</label>
                    </div>
        </div>

        <div class="foodCategory">
            <h4>Food Category</h4>
                    <?php 
                    $categories = RecipeCategory::getAllCategories();
                    foreach ($categories as $category) { ?>
                    <div class="category">
                        <div class="checkbox-wrapper-6">
                            <input class="tgl tgl-light" id="cat-<?php echo $category ?>" type="checkbox" name="categories[]" value="<?php echo $category ?>" <?php echo in_array($category, $selectedCategories) ? 'checked' : ''; ?>>
                            <label class="tgl-btn" for="cat-<?php echo $category ?>"></label>
                        </div>
                        <p><?php echo $category ?></p>
                    </div>
                    <?php } ?>
        </div>

        <div class="cookingTechnique">
            <h4>Cooking Technique</h4>
    
                <?php 
                $categories = CookingTechnique::getAllTechniques();
                foreach ($categories as $category) { ?>
                    <div class="category">
                        <div class="checkbox-wrapper-6">
                            <input class="tgl tgl-light" id="cat-<?php echo $category ?>" type="checkbox" name="techniques[]" value="<?php echo $category ?>" <?php echo in_array($category, $selectedTechniques) ? 'checked' : ''; ?>>
                            <label class="tgl-btn" for="cat-<?php echo $category ?>"></label>
                        </div>
                        <p><?php echo $category ?></p>
                    </div>
                <?php } ?>
            
            
        </div>

        <div class="dietaryPref">
            <h4>Dietary Preferences</h4>
                <div class="wrapper">
                    <?php 
                    $categories = RecipeCategory::getAllDietaryPreferences();
                    foreach ($categories as $category) { ?>
                        <div class="category">
                            <div class="checkbox-wrapper-6">
                                <input class="tgl tgl-light" id="cat-<?php echo $category ?>" type="checkbox" name="preferences[]" value="<?php echo $category ?>" <?php echo in_array($category, $selectedPreferences) ? 'checked' : ''; ?>>
                                <label class="tgl-btn" for="cat-<?php echo $category ?>"></label>
                            </div>
                            <p><?php echo $category ?></p>
                        </div>
                    <?php } ?>
                </div>
        </div>
    </div>
</form>
</div>


<?php 
unset($_SESSION["selectedCategories"]);
unset($_SESSION['selectedTechniques']);
unset($_SESSION['selectedPreferences']);

}


?>