<?php
require_once(__DIR__ . '/../database/ingredient.class.php');
require_once(__DIR__ . '/../database/ingredient_recipe.class.php');
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the values from the $_POST superglobal

    $recipeId = intval($_POST["recipeId"]);
    $name = $_POST["name"];
    $carbohydrate = floatval($_POST["carbohydrate"]);
    $protein = floatval($_POST["protein"]);
    $fat = floatval($_POST["fat"]);
    $quantity = floatval($_POST["quantity"]);
    $unit = $_POST["unit"];

    // Add Ingredient to database
    $ingredientId = Ingredient::addIngredient($name, $carbohydrate, $protein, $fat);
    IngredientRecipe::addIngredientToRecipe($recipeId, $ingredientId, $quantity, $unit);
    // Redirect to addIngredients.php
    header("Location: ../pages/addIngredients.php");

}?>