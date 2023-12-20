<?php
require_once(__DIR__ . '/../database/planRecipe.class.php');
require_once(__DIR__ . '/../database/weeklyPlan.class.php');

    $addRecipe = isset($_POST['addBt']);
    $finishPlan = isset($_POST['finishBt']);

if ($addRecipe) {
    $planId = intval($_POST['planId']);
    $recipeId = intval($_POST['recipeId']);
    $dayWeek = $_POST['dayWeek'];
    $timeMeal = $_POST['timeMeal'];
    $portion = floatval($_POST['portion']);

    // Add instance of PlanRecipe to database
    PlanRecipe::addPlanRecipe($planId, $recipeId, $dayWeek, $portion, $timeMeal);
    WeeklyPlan::updateWeeklyPlan($planId, $recipeId, $portion);
    header("Location: ../pages/addPlanRecipe.php?planId=$planId");
} else if ($finishPlan) {
    $planId = intval($_POST['planId']);
    header("Location: ../pages/plan.php?id=$planId");
}
?>