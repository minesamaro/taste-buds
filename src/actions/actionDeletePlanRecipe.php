<?php
require_once(__DIR__ . '/../database/weeklyPlan.class.php');


$planId = intval($_POST['planId']);
$recipeId = intval($_POST['recipeId']);
$dayWeek = $_POST['dayWeek'];
$timeMeal = $_POST['timeMeal'];
$portion = floatval($_POST['portion']);

WeeklyPlan::deleteRecipeFromWeeklyPlan($planId, $recipeId, $dayWeek, $timeMeal, $portion);

header("Location: ../pages/addPlanRecipe.php?planId=$planId");

?>