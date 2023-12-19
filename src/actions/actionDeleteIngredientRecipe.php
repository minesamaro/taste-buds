<?php
require_once(__DIR__ . '/../database/ingredient_recipe.class.php');

$ingredientId = intval($_POST['ingredientId']);
$recipeId = intval($_POST['recipeId']);
$quantity = floatval($_POST['quantity']);
$measurementUnit = $_POST['measurementUnit'];

IngredientRecipe::deleteIngredientFromRecipe($recipeId, $ingredientId, $measurementUnit, $quantity);
$ingredient = Ingredient::getIngredientById($ingredientId);
$ingredientMacronutrients = Ingredient::getIngredientMacronutrients($ingredientId);
$recipe = Recipe::getRecipeById($recipeId);
// Update recipe energy, carbohydrates, proteins and fats

if ($measurementUnit == "kg") {
    $quantity *= 1000;
} else if ($measurementUnit == "L") {
    $quantity *= 1000;
}

foreach ($ingredientMacronutrients as $macronutrient) {
    $kcalPerGram = Ingredient::getMacronutrientKcalPerGram($macronutrient['name']);
    switch ($macronutrient['name']) {
        case 'Carbohydrate':
            $recipe->carbohydrate -= $macronutrient['quantity']/100 * $quantity;
            $recipe->energy -= $macronutrient['quantity'] * $quantity * $kcalPerGram; // Change for value in database
            break;
        case 'Protein':
            $recipe->protein -= $macronutrient['quantity']/ 100 * $quantity;
            $recipe->energy -= $macronutrient['quantity'] * $quantity * $kcalPerGram;
            break;
        case 'Fat':
            $recipe->fat -= $macronutrient['quantity'] / 100 * $quantity;
            $recipe->energy -= $macronutrient['quantity'] * $quantity * $kcalPerGram;
            break;
    }
    $kcalPerGram = 0;
}

$recipe->updateRecipe();

header("Location: ../pages/addIngredients.php");
exit;
?>