<?php function addPlanRecipe($recipes, $planId) { ?>

<div item="addPlanRecipe">
<article class="content">
<h2>Add Recipe</h2>
<form method="POST" action="../actions/actionAddPlanRecipe.php" >
    <input type="hidden" name="planId" value="<?= $planId ?>" />
    <div class="card" id="planRecipeOptions">
        <div class="planRecipeOption">
        <label for="dayWeek">Day of the week</label>
        <select name="dayWeek" class="userSelect" required="true">
            <?php
            // Array with days of the week
            $days = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
            foreach ($days as $day) { ?>
                <option value="<?php echo $day ?>">
                    <?php echo $day ?>
                </option>
            <?php } ?>
        </select>
        </div>
        <div class="planRecipeOption">
        <label for="timeMeal">Meal Type</label>
        <select name="timeMeal" class="userSelect" required="true">
            <?php
            $meals = array("Breakfast", "Lunch", "Dinner", "Morning Snack", "Afternoon Snack", "Supper");
            foreach ($meals as $meal) { ?>
                <option value="<?php echo $meal ?>">
                    <?php echo $meal ?>
                </option>
            <?php } ?>
        </select>
        </div>
        <div class="planRecipeOption">
        <label for="portion">Portion</label>
        <input type="number" required="true" name="portion" step="any" placeholder="0.5" />
        </div>
    </div>
    <?php
    foreach ($recipes as $recipe) { ?>
        <input type="radio" style="display:none" required="true" id="recipe_<?= $recipe->id ?>" name="recipeId"
            value="<?= $recipe->id ?>" />
        <label for="recipe_<?= $recipe->id ?>">
            <div class="card card-with-img">
                <img class="card-img" src="<?= $recipe->image ?>" alt="<?= $recipe->name ?>" />
                <div>
                    <div class="card-header">
                        <h4><?= $recipe->name ?></h4>
                    </div>
                    <div class='card-content'>
                        <div class="card-body">
                            <h6><?= $recipe->preparationTime ?> mins</h6>
                            <h6>Difficulty: <?= $recipe->difficulty ?> / 5</h6>
                            <h6><?= $recipe->numberOfServings ?> Servings </h6>
                        </div>
                        <div class="card-side">
                            <h6>Total kcal: <?= $recipe->energy ?></h6>
                            <h6>Protein: <?= $recipe->protein ?> g</h6>
                            <h6>Carbohydrates: <?= $recipe->carbohydrate ?> g</h6>
                            <h6>Fat: <?= $recipe->fat ?> g</h6>
                        </div>
                    </div>
                </div>
            </div>
        </label>
    <?php } ?>
    <button id="addRecipeBt" type="submit" name="addBt" value="true">Add Recipe</button>
    <button id="finishPlanBt" type="submit" name="finishBt" value="true">Add and Finish Plan</button>
</form>
</article>
</div>

<?php } ?>