<?php
require_once(__DIR__ . '/../database/recipe.class.php');
session_start();

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Handle ordering
    $orderBy = $_POST['order']; // 'recent' or 'review'

    // Handle food categories, cooking techniques, and dietary preferences
    $selectedCategories = isset($_POST['categories']) ? $_POST['categories'] : [];
    $selectedTechniques = isset($_POST['techniques']) ? $_POST['techniques'] : [];
    $selectedPreferences = isset($_POST['preferences']) ? $_POST['preferences'] : [];

    
    $recipes = Recipe::getRecipesWithDetailsAndOrder($selectedCategories, $selectedTechniques, $selectedPreferences, $orderBy);
    $_SESSION['recipes'] = $recipes;

    // Set the selected categories, techniques, and preferences in the session
    $_SESSION['selectedCategories'] = $selectedCategories;
    $_SESSION['selectedTechniques'] = $selectedTechniques;
    $_SESSION['selectedPreferences'] = $selectedPreferences;
    $_SESSION['orderBy'] = $orderBy;


    
    //var_dump($_SESSION['selectedPreferences']);
    header("Location: ../pages/recipeIndex.php");
    exit();

    
} else {
    echo "Form not submitted.";
}
?>
