
<?php
require_once(__DIR__ . '/../database/commonUser.class.php');
require_once(__DIR__ . '/../database/person.class.php');

require_once(__DIR__ . '/../database/recipe.class.php');


function profileRecipes()
{
    if(isset($_GET['user_id'])) {
 
        $user_id = $_GET['user_id'];
        $isUser=FALSE;
  
    }
    else {
        $user_id=$_SESSION['user_id'] ;
        $isUser=TRUE;
    }

    $recipes=Recipe::getAllRecipesFromChef(intval($user_id));

?>
<article class='content'>
    <h2>My Recipes</h2>
<?php if (count($recipes) == 0) { ?>
    <h4>No recipes found</h4>
<?php }
else{
foreach ($recipes as $recipe) { 
    $recipeId = $recipe->id;
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
<?php } ?>
</article>


<?php } }?>
    
 