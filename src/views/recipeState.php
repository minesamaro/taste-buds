<?php 
require_once(__DIR__ . '/../database/recipe.class.php');
require_once(__DIR__ . '/../database/ingredient_recipe.class.php');
require_once(__DIR__ . '/../database/ingredient.class.php');

function showRecipeState($recipe){ ?>
<div id="recipeState">

        <h2 style="margin-bottom: 0.1em">Current Recipe:
        </h2>
        <div class="recipe-subtitle">
            <h5>Created on 
                <p><?php echo $recipe->submissionDate ?>
            </h5>
            <div class="recipe-macronutrients">
                <h5>Total kcal:
                    <p><?php echo $recipe->energy ?></p>
                </h5>
                <h5>Total carbohydrates:
                    <p><?php echo $recipe->carbohydrate ?></p>
                </h5>
                <h5>Total proteins:
                    <p><?php echo $recipe->protein ?></p>
                </h5>
                <h5>Total fats:
                    <p><?php echo $recipe->fat ?></p>
                </h5>
            </div>
        </div>
        <?php
        $ingredientRecipe = IngredientRecipe::getIngredientsForRecipe($recipe->id);
        foreach ($ingredientRecipe as $ingredient) {
            ?>
            <section class="card-small">
                <div class="card-header">
                    <h4>
                        <a href="#"><?php echo $ingredient->ingredient->name ?></a>
                    </h4>
                    
                    <h5>
                        <?php echo $ingredient->quantity . " " . $ingredient->measurementUnit ?>
                    </h5>
                    <h5>
                        <form action="../actions/actionDeleteIngredientRecipe.php" method="post">
                            <input type="hidden" name="ingredientId" value="<?php echo $ingredient->ingredient->id ?>">
                            <input type="hidden" name="recipeId" value="<?php echo $ingredient->recipe->id ?>">
                            <input type="hidden" name="quantity" value="<?php echo $ingredient->quantity ?>">
                            <input type="hidden" name="measurementUnit" value="<?php echo $ingredient->measurementUnit ?>">
                            <button type="submit" class="deleteBt">Delete</button>
                        </form>
                    </h5>
            </section>
            <?php
        }
        ?>
        <form id="finishRecipe" method="POST" action="../actions/actionAddRecipeIngredient.php">
        <input type="hidden" name="recipeId" value="<?= $recipe->id ?>" />
        <button id="finishRecipeBt" type="submit" name="finishBt" value="true">Finish Recipe</button>
</form>
</div> 

<?php 
}?>