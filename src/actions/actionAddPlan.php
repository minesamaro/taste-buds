<?php
// Add new plan to database with user id
require_once(__DIR__ . '/../database/weeklyPlan.class.php');

$userId = $_GET['id'];

//TODO: get nutritionist id from session
$planId = WeeklyPlan::addWeeklyPlan(1, $userId);

header("Location: ../pages/addPlanRecipe.php?planId=$planId");

?>