<?php
require_once(__DIR__ . '/../database/nutritionist_approval.class.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the recipe ID and user ID from the form
    $recipe_id = $_POST['recipe_id'];
    $user_id = $_POST['user_id'];

    $success = NutritionistApproval::deleteNutriApproval($recipe_id, $user_id);

    if ($success) {
        $_SESSION['msg'] = 'Recipe approval deleted successfully!';
    } else {
        $_SESSION['msg'] = 'Error deleting recipe approval.';
    }

    // Redirect to a success page
    $location =  "../pages/recipe.php?recipe_id=" . $recipe_id;
    header('Location: ' . $location);
    exit;
}