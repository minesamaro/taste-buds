<?php
session_start();
require_once(__DIR__ . '/../database/weeklyPlan.class.php');

$userId = $_GET['id'];

//TODO: get nutritionist id from session
$planId = WeeklyPlan::addWeeklyPlan($_SESSION['user_id'], $userId);

header("Location: ../pages/addPlanRecipe.php?planId=$planId");

?>