<?php
require_once(__DIR__ . '/../database/recipe_rating.class.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipeId = $_POST['recipeId'];
    $ratingId = $_POST['ratingId'];
    $rating = RecipeRating::deleteRating($ratingId, $recipeId);
    header("Location: ../pages/recipe.php?recipe_id=$recipeId#recipe-ratings");
    exit();
} else {
    echo "Form not submitted.";
}