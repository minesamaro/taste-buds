<?php
require_once(__DIR__ . '/../database/weeklyPlan.class.php');


$planId = $_POST['planId'];
$recipeId = $_POST['recipeId'];

WeeklyPlan::deleteRecipeFromWeeklyPlan($planId, $recipeId);

header("Location: ../pages/addPlanRecipe.php?planId=$planId");

?>