<?php 
require_once(__DIR__ . '/../database/recipe.class.php');

function recipeForm(){
    ?>
    <article class="content">
        <h2>Create a New Recipe</h2>
        </div>
        <div class="addRecipe__form">
            
            <form class="addRecipe__form" action="../actionAddRecipe.php" method="post">

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
            <select id="difficulty" name="difficulty" required>
                <option value="1">Easy</option>
                <option value="2">Moderate</option>
                <option value="3">Difficult</option>
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
            <label for="file">Select Image:</label>
            <input type="file" name="file" id="file" accept="image/*">
            </div>

            <!-- Submit Button -->
            <button type="submit">Create Recipe</button>
            </form>
        </div>
    </article>
<?php
}
?>