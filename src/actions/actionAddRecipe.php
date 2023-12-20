<?php
session_start();
require_once(__DIR__ . '/../database/recipe.class.php');
$_SESSION['$recipeId'] = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form was submitted
    
    // Retrieve form data
    $name = $_POST['name'];
    $preparationTime = $_POST['preparationTime'];
    $difficulty = intval($_POST['difficulty']);
    $numberOfServings = intval($_POST['numberOfServings']);
    $preparationMethod = nl2br($_POST['preparationMethod']);
    $chef = $_SESSION['user_id'];
    // Get image and upload it to the server

    $uploadDir = '../img/recipes/';
    // Get last saved recipe id in database
    $lastRecipeId = Recipe::getLastRecipeId();
    // Get the file extension
    $extension = '.jpg';

    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = '../img/recipes/';
        // Get last saved recipe id in database
        $lastRecipeId = Recipe::getLastRecipeId();
        // Get the file extension
        $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $uploadFile = $uploadDir . $lastRecipeId + 1 . '.' . $extension;
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
            // File was successfully uploaded
            $image = $uploadFile;
        } else {
            // Handle save default image with the recipe id on the folder
            copy('../img/recipes/default.jpg', $uploadFile);
            $image = $uploadFile;            
        }
    } else {
        // Handle file upload error by using a default image
        $uploadFile = $uploadDir . $lastRecipeId + 1 . '.' . $extension;
        copy('../img/recipes/default.jpg', $uploadFile);
        $image = $uploadFile;
    }

    // Perform database insert or any other necessary actions
    // Insert the form data into your database or perform other processing
    $_SESSION['recipeId'] = Recipe::addRecipe($name, $preparationTime, $difficulty, $numberOfServings, $image, $preparationMethod, $chef);
    // Redirect to a success page or handle the response accordingly
    header('Location: ../pages/addIngredients.php');
    exit;
}

