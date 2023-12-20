<?php
require_once(__DIR__ . '/../database/nutritionist_approval.class.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the recipe ID and user ID from the form
    $recipe_id = $_POST['recipe_id'];
    $user_id = $_POST['user_id'];

    $success = NutritionistApproval::addNutriApproval($recipe_id, $user_id);

    if ($success) {
        $_SESSION['msg'] = 'Recipe approved successfully!';
    } else {
        $_SESSION['msg'] = 'Error approving recipe.';
    }

    // Redirect to a success page
    $location =  "../pages/recipe.php?recipe_id=" . $recipe_id;
    header('Location: ' . $location);
    exit;
}
