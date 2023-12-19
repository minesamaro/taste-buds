<?php 
require_once(__DIR__ . '/../database/recipe.class.php');
require_once(__DIR__ . '/../database/ingredient_recipe.class.php');
require_once(__DIR__ . '/../database/ingredient.class.php');

function showRecipeState($recipe){ ?>
<div item="planState">

        <h2 style="margin-bottom: 0.1em">Current Recipe:
        </h2>
        <div class="plan-subtitle">
            <h5>Created on 
                <?php echo $recipe->submissionDate ?>
            </h5>
            <h5>Total kcal:
                <?php echo $recipe->energy ?>
            </h5>
            <h5>Total carbohydrates:
                <?php echo $recipe->carbohydrate ?>
            </h5>
            <h5>Total proteins:
                <?php echo $recipe->protein ?>
            </h5>
            <h5>Total fats:
                <?php echo $recipe->fat ?>
            </h5>
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