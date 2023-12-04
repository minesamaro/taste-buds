<?php
require_once(__DIR__ . '/../views/footer.php');
require_once(__DIR__ . '/../views/header.php');
require_once(__DIR__ . '/../views/addPlanRecipe.php');
require_once(__DIR__ . '/../views/planState.php');
require_once(__DIR__ . '/../database/recipe.class.php');
require_once(__DIR__ . '/../database/weeklyPlan.class.php');


$planId = $_GET['planId'];

$plan = WeeklyPlan::getWeeklyPlan(intval($planId));
$recipes = Recipe::getAllRecipes();

head("Add Recipe");
?>
<div class="planBundle">
<?php
    addPlanRecipe($recipes, $planId);
    showPlanState($plan);
?>
</div>
<?php
footer();
?>