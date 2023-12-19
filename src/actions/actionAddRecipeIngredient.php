<?php
//session_start();
require_once(__DIR__ . '/../database/ingredient_recipe.class.php');
require_once(__DIR__ . '/../database/recipe.class.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST['finishBt'])) {
        $id = $_POST['recipeId'];
        header("Location: ../pages/recipe.php?recipe_id=" . $id);
        exit;
    }

    $recipeId = intval($_POST['recipeId']);
    $ingredientId = intval($_POST['ingredientId']);
    $quantity = floatval($_POST['quantity'][$ingredientId]);
    $measurementUnit = $_POST['unit'][$ingredientId];

    IngredientRecipe::addIngredientToRecipe($recipeId, $ingredientId, $quantity, $measurementUnit);

    // Update recipe energy, carbohydrates, proteins and fats
    // - Get the macronutrients of the ingredient and multiply by the quantity
    // - Add the macronutrients to the recipe
    if ($measurementUnit == "kg") {
        $quantity *= 1000;
    } else if ($measurementUnit == "L") {
        $quantity *= 1000;
    }

    $ingredient = Ingredient::getIngredientById($ingredientId);
    $ingredientMacronutrients = Ingredient::getIngredientMacronutrients($ingredientId);
    $recipe = Recipe::getRecipeById($recipeId);

    foreach ($ingredientMacronutrients as $macronutrient) {
        $kcalPerGram = Ingredient::getMacronutrientKcalPerGram($macronutrient['name']);
        switch ($macronutrient['name']) {
            case 'Carbohydrate':
                $recipe->carbohydrate += $macronutrient['quantity']/100 * $quantity;
                $recipe->energy += $macronutrient['quantity'] * $quantity * $kcalPerGram; // Change for value in database
                break;
            case 'Protein':
                $recipe->protein += $macronutrient['quantity']/ 100 * $quantity;
                $recipe->energy += $macronutrient['quantity'] * $quantity * $kcalPerGram;
                break;
            case 'Fat':
                $recipe->fat += $macronutrient['quantity'] / 100 * $quantity;
                $recipe->energy += $macronutrient['quantity'] * $quantity * $kcalPerGram;
                break;
        }
        $kcalPerGram = 0;
    }

    $recipe->updateRecipe();

    
    
    header("Location: ../pages/addIngredients.php");
    
    
} else {
    echo "Form not submitted.";
}

?>