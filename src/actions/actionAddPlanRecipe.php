<?php
require_once(__DIR__ . '/../database/planRecipe.class.php');
require_once(__DIR__ . '/../database/weeklyPlan.class.php');
// Lacks recipe id
$planId = intval($_POST['planId']);
$recipeId = intval($_POST['recipeId']);
$dayWeek = $_POST['dayWeek'];
$timeMeal = $_POST['timeMeal'];
$portion = floatval($_POST['portion']);
$addRecipe = isset($_POST['addBt']);
$finishPlan = isset($_POST['finishBt']);

// Add instance of PlanRecipe to database
PlanRecipe::addPlanRecipe($planId, $recipeId, $dayWeek, $portion, $timeMeal);
WeeklyPlan::updateWeeklyPlan($planId, $recipeId, $portion);

if ($addRecipe) {
    header("Location: ../pages/addPlanRecipe.php?planId=$planId");
} else if ($finishPlan) {
    header("Location: ../pages/plan.php?id=$planId");
}
?>