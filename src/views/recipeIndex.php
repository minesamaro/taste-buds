<?php 
require_once(__DIR__ . '/../database/recipe.class.php');
function recipeIndex($recipes) { 
    ?>
<div item="recipeIndex">
<article class="content">
<h2>Recipes</h2>
<?php
foreach ($recipes as $recipe) { 
    $recipeId = $recipe->id;
    ?>
        <div class="card card-with-img">
            <img class="card-img" src="<?= $recipe->image ?>" alt="<?= $recipe->name ?>" />
            <div>
                <div class="card-header">
                    <a href="../pages/recipe.php?recipe_id?<?php $recipeId ?>"><h4><?= $recipe->name ?></h4></a>
                </div>
                <div class="card-body">
                    <h6><?= $recipe->preparationTime ?> mins</h6>
                    <h6>Categories: 
                        <?php foreach ($recipe->getCategories() as $category) {
                            echo $category ;
                        }?>
                    </h6>
                    <h6>Techniques: 
                        <?php foreach ($recipe->getTechniques() as $technique) {
                            echo $technique ;
                        }?>
                    </h6>
                    <h6>Preferences: 
                        <?php foreach ($recipe->getPreferences() as $preference) {
                            echo $preference ;
                        }?>
                    </h6>
                    <h6>Difficulty: <?= $recipe->difficulty ?></h6>
                </div>
            </div>
        </div>
<?php } ?>
</article>
</div>

<?php } ?>