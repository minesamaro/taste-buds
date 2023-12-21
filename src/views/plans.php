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
                <?php 
                $date = new DateTime($plan->creationDate);
                echo $date->format('d-m-Y');?>
            </h5>
            <h5>Total kcal:
                <?php echo $plan->totalKcal ?>
            </h5>
            <h5>Created by:
                <?php 
                $nutritionist = Person::getPersonById($plan->idNutritionist);?>
                <a href="../pages/profile.php?person_id=<?php echo $plan->idNutritionist ?>">
                    <?php echo $nutritionist->first_name . " " . $nutritionist->surname ?>
                </a>
            </h5>
        </div>

        <?php

        $daysWeek = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
        foreach ($daysWeek as $day) { ?>
        <h3><?php echo $day ?></h3>
        <?php
        // Get the energy by day of the week
        ?>
        <h5>Energy: <?php echo $plan->getEnergyByDay($day)?> kcal</h5>
        <?php
        $dayRecipes = $plan->getPlanRecipesByDay($day);
        foreach ($dayRecipes as $planRecipe) {
            ?>
            <section class="card card-with-img">
                <img class="card-img" src="<?php echo $planRecipe->recipe->image ?>" alt="<?php echo $planRecipe->recipe->name ?>" />
                <div>
                    <div class="card-header">
                        <h4>
                            <a href="../pages/recipe.php?recipe_id=<?php echo $planRecipe->recipe->id ?>"><?php echo $planRecipe->recipe->name ?></a>
                        </h4>
                        <h5> Difficulty:
                        <?php echo $planRecipe->recipe->difficulty ?>/5
                        </h5>
                    </div>
                    <div class="card-body">
                        <h6>
                            <?php echo $planRecipe->dayWeek ?>,
                            <?php echo $planRecipe->timeMeal ?>
                        </h6>
                        <h6>
                            <?php echo $planRecipe->portion ?>
                            <?php if($planRecipe->portion != 1) echo "portions"; 
                            else echo "portion"?>
                        </h6>
                    </div>
                </div>
            </section>
            <?php
        }
        

    
}?>
</article>

<?php
}
?>