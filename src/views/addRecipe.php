<?php 
require_once(__DIR__ . '/../database/recipe.class.php');
require_once(__DIR__ . '/../database/recipe_category.class.php');
require_once(__DIR__ . '/../database/cooking.technique.class.php');


function recipeForm(){
    ?>
    <article class="content">
        <h2>Create a New Recipe</h2>
        </div>
        <div class="addRecipe__form">
            
            <form class="addRecipe__form" action="../actions/actionAddRecipe.php" method="post" enctype="multipart/form-data">

            <div><!-- Recipe Name -->
            <label for="name">Recipe Title:</label>
            <input type="text" id="name" name="name" required>
            </div>

            <div>
            <!-- Preparation Time (in minutes) -->
            <label for="preparationTime">Preparation Time (minutes):</label>
            <input type="number" id="preparationTime" name="preparationTime" step="any" required>
            </div>

            <div>
            <!-- Difficulty Level -->
            <label for="difficulty">Difficulty Level:</label>
            <select name="difficulty" id="difficulty" required>
                <option value="1">1 - Very Easy</option>
                <option value="2">2 - Easy</option>
                <option value="3">3 - Medium</option>
                <option value="4">4 - Hard</option>
                <option value="5">5 - Very Hard</option>
            </select>
            </div>

            <div>
            <!-- Number of Servings -->
            <label for="numberOfServings">Number of Servings:</label>
            <input type="number" id="numberOfServings" name="numberOfServings" step="any" required>
            </div>
            
            <div id="preparation-method">
            <!-- Preparation Method -->
            <label for="preparationMethod">Preparation Method:</label>
            <textarea id="preparationMethod" name="preparationMethod" rows="4" required></textarea>
            </div>

            <!-- Image -->
            <label for="image">Select Image:</label>
            <input type="file" name="image" id="image" accept="image/*">
            </div>

            <div class="recipe-categories">
                <!-- Select Categories -->
                <div class="foodCategory">
                        <h4>Select Food Category</h4>
                        <?php 
                        $categories = RecipeCategory::getAllCategories();
                        foreach ($categories as $category) { ?>
                        <div class="category">
                            <div class="checkbox-wrapper-6">
                                <input class="tgl tgl-light" id="cat-<?php echo $category ?>" type="checkbox" name="categories[]">
                                <label class="tgl-btn" for="cat-<?php echo $category ?>"></label>
                            </div>
                            <p><?php echo $category ?></p>
                        </div>
                        <?php 
                        } ?>
                        <div class="category">
                            <div class="checkbox-wrapper-6 checkbox-other">
                                <input class="tgl tgl-light" id="cat-other" type="checkbox" name="categories[]">
                                <label class="tgl-btn" for="cat-other"></label>
                                <input type="text" name="other-cat">
                            </div>
                        </div>
                </div>

                <!-- Select Techniques -->
                <div class="cookingTechnique">
                <h4>Cooking Technique</h4>
        
                    <?php 
                    $categories = CookingTechnique::getAllTechniques();
                    foreach ($categories as $category) { ?>
                        <div class="category">
                            <div class="checkbox-wrapper-6">
                                <input class="tgl tgl-light" id="cat-<?php echo $category ?>" type="checkbox" name="techniques[]" >
                                <label class="tgl-btn" for="cat-<?php echo $category ?>"></label>
                            </div>
                            <p><?php echo $category ?></p>
                        </div>
                    <?php } ?>
                    <div class="category">
                            <div class="checkbox-wrapper-6 checkbox-other">
                                <input class="tgl tgl-light" id="tech-other" type="checkbox" name="techniques[]">
                                <label class="tgl-btn" for="tech-other"></label>
                                <input type="text" name="other-tech">
                            </div>
                    </div>
                
                
                </div>

                <!-- Select Dietary Preferences -->
                <div class="dietaryPref">
                <h4>Dietary Preferences</h4>
                    <div class="wrapper">
                        <?php 
                        $categories = RecipeCategory::getAllDietaryPreferences();
                        foreach ($categories as $category) { ?>
                            <div class="category">
                                <div class="checkbox-wrapper-6">
                                    <input class="tgl tgl-light" id="cat-<?php echo $category ?>" type="checkbox" name="preferences[]" >
                                    <label class="tgl-btn" for="cat-<?php echo $category ?>"></label>
                                </div>
                                <p><?php echo $category ?></p>
                            </div>
                        <?php } ?>
                        <div class="category">
                            <div class="checkbox-wrapper-6 checkbox-other">
                                <input class="tgl tgl-light" id="pref-other" type="checkbox" name="techniques[]">
                                <label class="tgl-btn" for="pref-other"></label>
                                <input type="text" name="other-pref">
                            </div>
                    </div>
                    </div>
                </div>
            </div>
            
            

            <!-- Submit Button -->
            <button type="submit">Create Recipe</button>
            </form>
        </div>
    </article>
<?php
}
?>