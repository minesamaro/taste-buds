<?php
session_start(); //ver esta parte, dá-me um warning se nao estiver comentado

// Include the RecipeRating class
require_once(__DIR__ . '/../database/recipe_rating.class.php');

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if the user is logged in - can only add a rating if logged in
    if (isset($_SESSION['user_id'])) {
        // Retrieve user ID from the session
        $user_id = $_SESSION['user_id'];

        // Retrieve recipe ID from the URL
        $recipe_id = $_GET['recipe_id'] ?? 1;

        // Validate and sanitize inputs
        $rating_value = $_POST['recipe-write_rating_value'];
        var_dump($rating_value);
        $rating_comment = isset($_POST['recipe-write_rating_comment']) ? $_POST['recipe-write_rating_comment'] : null; // optional input


        // Create an array with rating data for adding to the database using addRating function
        $ratingData = array(
            'user_id' => $user_id,
            'recipe_id' => $recipe_id,
            'rating_value' => $rating_value,
            'comment' => $rating_comment,
        );

        // Add the rating to the database
        RecipeRating::addRating($ratingData);

        // Set a success message in the session
        $_SESSION['msg'] = "Rating added successfully!";
        
        // Redirect to the recipe page
        header("Location: ../pages/recipe.php?recipe_id=$recipe_id");

    // If the user is not logged in    
    } else {
        // Redirect to the login page if the user is not logged in
        $_SESSION['msg'] = "Error: You must log in to submit a rating.";
        header("Location: ../pages/recipe.php");
    }
}

} catch (PDOException $e) {
    $_SESSION['msg'] = 'Error: ' . $e->getMessage();
}
?>