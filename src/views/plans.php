<?php
function viewPlan($plan)
{
    ?>

    <article class="content">
        <h2 style="margin-bottom: 0.1em">Weekly Plan
            <?php echo $plan->id ?>
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
            <section class="card">
                <div class="card-header">
                    <h4>
                        <a href="#"><?php echo $planRecipe->recipe->name ?></a>
                    </h4>
                    <h5>
                       <?php echo $planRecipe->recipe->difficulty ?>/5
                    </h5>
                </div>
                <h6>
                    <?php echo $planRecipe->dayWeek ?>,
                    <?php echo $planRecipe->timeMeal ?>
                </h6>
                <h6>
                    <?php echo $planRecipe->portion ?>
                    <?php if($planRecipe->portion != 1) echo "portions"; 
                    else echo "portion"?>
                </h6>
            </section>
            <?php
        }
        

    
}?>
</article>

<?php
}
?>