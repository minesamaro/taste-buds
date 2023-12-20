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
        <div class="card card-with-img">
            <img class="card-img" src="<?= $recipe->image ?>" alt="<?= $recipe->name ?>" />
            <div>
                <div class="card-header">
                    <a href="../pages/recipe.php?recipe_id=<?php echo $recipe->id?>"><h4><?= $recipe->name ?></h4></a>
                    
                </div>
                <div class="card-body">
                    <h6><?= $recipe->preparationTime ?> mins</h6>
                    <h6>Difficulty: <?= $recipe->difficulty ?> /5</h6>
                    <h6>Verified on <?php echo date("d-m-Y", strtotime($approval->approval_date));  ?></h6>
                    <div class= "card-categories">
                        <div class= "category">                             
                            <?php foreach ($recipe->getCategories() as $category) {
                                echo "<h6>";
                                echo $category ;
                                echo "</h6>";
                            }?>                            
                        </div>
                        <div class= "technique">
                            <?php foreach ($recipe->getTechniques() as $technique) {
                                echo "<h6>";
                                echo $technique ;
                                echo "</h6>";
                            }?>                            
                        </div>
                        <div class= "preference">                            
                            <?php foreach ($recipe->getPreferences() as $preference) {
                                echo "<h6>";
                                echo $preference ;
                                echo "</h6>";
                            }?>                            
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php } 
        ?> 
        </article>
    <?php }
    }
?>