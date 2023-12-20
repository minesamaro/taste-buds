
<?php 
require_once(__DIR__ . '/../database/person.class.php');
require_once(__DIR__ . '/../database/recipe.class.php');
require_once(__DIR__ . '/../database/nutritionist_approval.class.php');


function profileApprovals()
{
    if(isset($_GET['user_id'])) {
 
        $user_id = $_GET['user_id'];
        $isUser=FALSE;
        if(isset($_SESSION['user_id']) and $_SESSION['user_id']==$user_id) {
        
            $isUser=TRUE;}
  
    }
    else {
        $user_id=$_SESSION['user_id'] ;
        $isUser=TRUE;
    }
    
    $approvals=NutritionistApproval::getAllApprovalsFromNutri($user_id);
    
    $nutri=Person::getPersonById($user_id);

?>
    
    <article class="content">
        <h2><?php echo $nutri->first_name ?>'s Approvals</h2>
        <?php 
        if (count($approvals) == 0) { ?>
            <h4>No approvals found</h4></article>
        <?php }
        else{
        foreach ($approvals as $approval) { 
            $recipeId = $approval->recipe_id;
            
            $recipe=Recipe::getRecipeById($recipeId);
        ?> 
            <section class="card">
                <div class="card-header">
                    <h4>
                        <a href="../pages/recipe.php?id=<?php echo $recipeId?>"><? echo $recipe->name ?></a>

                    </h4>
                </div>
                    
                        
                    <h6><?php echo date("d-m-Y", strtotime($approval->approval_date));  ?></h6>
        
                </div>


            </section>
        <?php } 
        ?> 
        </article>
    <?php }
    }
?>