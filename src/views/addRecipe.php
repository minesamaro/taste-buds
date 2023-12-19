<?php 
require_once(__DIR__ . '/../database/recipe.class.php');

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
            <input type="number" id="preparationTime" name="preparationTime" required>
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
            <input type="number" id="numberOfServings" name="numberOfServings" required>
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

            <!-- Submit Button -->
            <button type="submit">Create Recipe</button>
            </form>
        </div>
    </article>
<?php
}
?>