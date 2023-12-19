
<?php
require_once(__DIR__ . '/../database/commonUser.class.php');
require_once(__DIR__ . '/../database/person.class.php');

require_once(__DIR__ . '/../database/weeklyPlan.class.php');


function profilePlans()
{
    $user_id=6;
    $plan=CommonUser::getPlansByUserId($user_id); 
?>
    
    <article class="content">
        <h2 style="margin-bottom: 0.1em">My Plans</h2>

        <section class="card">
                <div class="card-header">
                    <h4>
                        <a href="#">Weekly Plan <?php echo $plan->id ?></a>
                    </h4>
                    
                    <h6><?php echo $plan->creationDate ?></h6>
                    <h5> <?php echo $plan->totalKcal ?>kcal</h5>
                </div>


            </section>

    </article>

<?php
}
?>