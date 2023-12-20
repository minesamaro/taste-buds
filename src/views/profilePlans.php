
<?php
require_once(__DIR__ . '/../database/commonUser.class.php');
require_once(__DIR__ . '/../database/person.class.php');

require_once(__DIR__ . '/../database/weeklyPlan.class.php');


function profilePlans()
{
    $user_id=$_SESSION['user_id'] ;
    if (Person::isNutritionist($user_id)){
        $plans=Nutritionist::getPlansByNutriId($user_id); 
    }
    elseif(Person::isCommonUser($user_id)){
        $plans=CommonUser::getPlansByUserId($user_id); 
    }
?>
    
    <article class="content">
        <h2>My Plans</h2>
        <?php 
        if (count($plans) == 0) { ?>
            <h4>No plans found</h4>
        <?php }
        else{
        foreach ($plans as $plan) { 
            $planId = $plan->id;
        ?> 
            <section class="card">
                <div class="card-header">
                    <h4>
                        <a href="../pages/plan.php?id=<?php echo $plan->id ?>">Weekly Plan <?php echo $plan->id ?></a>
                    </h4>
                        
                    <h6><?php echo $plan->creationDate ?></h6>
                    <h5> <?php echo $plan->totalKcal ?>kcal</h5>
                </div>


            </section>

    

<?php
}} ?>
</article>
<?php
}
?>