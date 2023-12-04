<?php
// Add new plan to database with user id
require_once(__DIR__ . '/../database/weeklyPlan.class.php');

$userId = $_GET['id'];

$planId = WeeklyPlan::addWeeklyPlan(1, $userId);

header("Location: ../pages/addPlanRecipe.php?planId=$planId");

?>