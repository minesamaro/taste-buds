<?php 
require_once(__DIR__ . '/../database/recipe.class.php');
require_once(__DIR__ . '/../database/planRecipe.class.php');

function showPlanState($plan){ ?>
<div item="planState">

        <h2 style="margin-bottom: 0.1em">Current Plan:
        </h2>
        <div class="plan-subtitle">
            <h5>Created on
                <?php echo $plan->creationDate ?>
            </h5>
            <h5>Total kcal:
                <?php echo $plan->totalKcal ?>
            </h5>
        </div>

        
    <?php 
    $daysWeek = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
    foreach ($daysWeek as $day) { ?>
        <h3><?php echo $day ?></h3>
        <?php
        $dayRecipes = $plan->getPlanRecipesByDay($day);
        foreach ($dayRecipes as $planRecipe) {
            ?>
            <section class="card-small">
                <div class="card-header">
                    <h4>
                        <a href="#"><?php echo $planRecipe->recipe->name ?></a>
                    </h4>
                    <h5>
                        <form action="../actions/actionDeletePlanRecipe.php" method="post">
                            <input type="hidden" name="planId" value="<?php echo $plan->id ?>">
                            <input type="hidden" name="recipeId" value="<?php echo $planRecipe->recipeId ?>">
                            <input type="hidden" name="dayWeek" value="<?php echo $planRecipe->dayWeek ?>">
                            <input type="hidden" name="timeMeal" value="<?php echo $planRecipe->timeMeal ?>">
                            <input type="hidden" name="portion" value="<?php echo $planRecipe->portion ?>">
                            <button type="submit" class="deleteBt">Delete</button>
                        </form>
                    </h5>
                </div>
                <p>
                    <?php echo $planRecipe->dayWeek ?>,
                    <?php echo $planRecipe->timeMeal ?>
                    <?php echo $planRecipe->portion ?> portion
                </p>
            </section>
            <?php
        }
        
    }?>
</div> 
<?php 
}?>