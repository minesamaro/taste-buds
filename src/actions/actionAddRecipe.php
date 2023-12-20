<?php
session_start();
require_once(__DIR__ . '/../database/recipe.class.php');
require_once(__DIR__ . '/../database/recipe.category.class.php');
require_once(__DIR__ . '/../database/cooking.technique.class.php');
require_once(__DIR__ . '/../database/recipe_dietarypref.class.php');

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

    // Create the categories, techniques and preferences for the recipe
    // CATEGORIES
    // Get selected categories
    $categories = array();
    if (isset($_POST['categories'])) {
        $categories = $_POST['categories'];
        RecipeCategory::addRecipeCategories($_SESSION['recipeId'], $categories);
    }
    // Check if new categories were added
    if (isset($_POST['new-category'])) {
        if (in_array($_POST['other-cat'], RecipeCategory::getAllCategories()))
        {
            RecipeCategory::addRecipeCategories($_SESSION['recipeId'], array($_POST['other-cat']));
        } else {
            $newCategory = $_POST['other-cat'];
            RecipeCategory::addNewRecipeCategories($_SESSION['recipeId'], $newCategory);
        }
    }

    // TECHNIQUES
    // Get selected techniques
    $techniques = array();
    if (isset($_POST['techniques'])) {
        $techniques = $_POST['techniques'];
        CookingTechnique::addRecipeTechniques($_SESSION['recipeId'], $techniques);
    }
    // Check if new techniques were added
    if (isset($_POST['new-technique'])) {
        if (in_array($_POST['other-tech'], CookingTechnique::getAllTechniques()))
        {
            CookingTechnique::addRecipeTechniques($_SESSION['recipeId'], array($_POST['other-tech']));
        } else {
            $newTechniques = $_POST['other-tech'];
            CookingTechnique::addNewRecipeTechnique($_SESSION['recipeId'], $newTechniques);
        }
    }

    // PREFERENCES
    // Get selected preferences
    $preferences = array();
    if (isset($_POST['preferences'])) {
        $preferences = $_POST['preferences'];
        RecipeDietaryPref::addRecipePreferences($_SESSION['recipeId'], $preferences);
    }
    // Check if new preferences were added
    if (isset($_POST['new-prefs'])) {
        if (in_array($_POST['other-pref'], RecipeDietaryPref::getAllDietaryPreferences()))
        {
            RecipeDietaryPref::addRecipePreferences($_SESSION['recipeId'], array($_POST['other-pref']));
        } else {
            $newPreference = $_POST['other-pref'];
            RecipeDietaryPref::addNewRecipePreference($_SESSION['recipeId'], $newPreference);
        }
    }


    // Redirect to a success page or handle the response accordingly
    header('Location: ../pages/addIngredients.php');
    exit;
}

