<?php 
require_once(__DIR__ . '/../database/recipe.class.php');
function recipeIndex($recipes, $page, $show) { 
    ?>
<div item="recipeIndex">
<article class="content">
<h2>Recipes</h2>
<?php

if (count($recipes) == 0) { ?>
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
<?php } 

if ( $show) { ?>
<div class="page-number">
    <?php if ($page > 1) { ?>
        <a href="../pages/recipeIndex.php?page=<?= $page - 1; ?>"> &#x2190; </a>
    <?php } ?>
    <p> <?= $page; ?> / <?= Recipe::getNumberOfPages(); ?></p>
    <?php if ($page < Recipe::getNumberOfPages()) { ?>
        <a href="../pages/recipeIndex.php?page=<?= $page + 1; ?>"> &#x2192; </a>
    <?php } ?>
</div>
<?php } ?>
</article>
</div>

<?php } }?>