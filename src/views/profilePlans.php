
<?php
require_once(__DIR__ . '/../database/commonUser.class.php');
require_once(__DIR__ . '/../database/person.class.php');

require_once(__DIR__ . '/../database/weeklyPlan.class.php');


function profilePlans()
{
    $user_id=$_SESSION['user_id'] ;
    if (Person::isNutritionist($user_id)){
        $plans=Nutritionist::getPlansByNutriId($user_id); 
        $isNutri=true;
    }
    elseif(Person::isCommonUser($user_id)){
        $plans=CommonUser::getPlansByUserId($user_id); 
        $isNutri=false;
        
    }
    

?>
    
    <article class="content">
        <h2>My Plans</h2>
        <?php 
        if (count($plans) == 0) { ?>
            <h4>No plans found</h4></article>
        <?php }
        else{
        foreach ($plans as $plan) { 
            $planId = $plan->id;
        ?> 
            <section class="card">
                <div class="card-header">
                    <?php if($isNutri){
                        $common=Person::getPersonById($plan->idCommonUser);
                        ?><h4>
                            <a href="../pages/plan.php?id=<?php echo $plan->id ?>">Weekly Plan for <?php echo $common->first_name ?> <?php echo $common->surname ?></a>
                        </h4> <?php
                    }else{
                    $nutri=Person::getPersonById($plan->idNutritionist);
                        ?>
                            <h4>
                               <a href="../pages/plan.php?id=<?php echo $plan->id ?>">Weekly Plan by <?php echo $nutri->first_name ?> <?php echo $nutri->surname ?></a>
                            </h4> <?php
                        }?>
                    
                        
                    <h6><?php 
                    $date = new DateTime($plan->creationDate);
                    echo $date->format('d-m-Y'); 
                    ?></h6>
                    <h5> <?php echo $plan->totalKcal ?>kcal</h5>
                </div>


            </section>

    

<?php
}} ?>
</article>
<?php
}
?>