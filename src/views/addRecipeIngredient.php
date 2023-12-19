<?php 
require_once(__DIR__ . '/../database/ingredient.class.php');
function addRecipeIngredient($ingredients, $recipeId) { 
    $ingredientsId = IngredientRecipe::getIngredientIdsinRecipe($recipeId);
    ?>

<div id="addRecipeIngredient">
<article class="content">
<h2>Add Ingredient</h2>
<form method="POST" action="../actions/actionAddRecipeIngredient.php" >
    <input type="hidden" name="recipeId" value="<?= $recipeId ?>" />
    <?php
    foreach ($ingredients as $ingredient) { 
        // Check if ingredient is already in recipe
        if(in_array($ingredient->id, $ingredientsId)){
            continue;
        }
        ?>
        <input type="radio" style="display:none" required="true" id="ingredient_<?= $ingredient->id ?>" name="ingredientId"
            value="<?= $ingredient->id ?>" />
        <label for="ingredient_<?= $ingredient->id ?>">
            <div class="card">
                <div>
                    <div class="card-header">
                        <h4><?= $ingredient->name ?></h4>
                    </div>
                    <div class="card-body">
                        <?php
                            $macronutrients = Ingredient:: getIngredientMacronutrients($ingredient->id);
                            foreach ($macronutrients as $macronutrient) { 
                                ?>
                                <h6><?= $macronutrient["name"] ?>: <?= $macronutrient["quantity"] ?> g /100 g</h6>
                                
                        <?php } ?>
                        <div id="ingredient-input-hidden">
                            <input type="number" name="quantity[<?=$ingredient->id?>]" placeholder="Enter quantity" min="0" step="0.00001">
                            <select name="unit[<?=$ingredient->id?>]">
                                <option value="g">g</option>
                                <option value="kg">kg</option>
                                <option value="mL">mL</option>
                                <option value="L">L</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </label>
    <?php } ?>
    <button id="addIngredientBt" type="submit" name="addBt" value="true">Add Ingredient</button>
</form>
</article>
</div>
<?php } ?>