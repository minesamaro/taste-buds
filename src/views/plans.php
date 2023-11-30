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
        foreach ($plan->planRecipes as $planRecipe) {
            ?>
            <section class="recipe-card">
                <div class="recipe-card-header">
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
                    <?php echo $planRecipe->portion ?> portion
                </h6>
            </section>
            <?php
        }
        ?>
    </article>

    <?php
}
?>