<?php 
require_once(__DIR__ . '/../database/recipe.class.php');
require_once(__DIR__ . '/../database/ingredient_recipe.class.php');
require_once(__DIR__ . '/../database/ingredient.class.php');

function showRecipeState($recipe){ ?>
<div item="planState">

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
            </section>
            <?php
        }
        ?>
</div> 
<?php 
}?>