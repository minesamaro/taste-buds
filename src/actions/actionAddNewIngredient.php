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

    if (Ingredient::ingredientExists($name)) {
        // Ingredient already exists in database
        $ingredientId = Ingredient::getIngredientId($name);
        IngredientRecipe::addIngredientToRecipe($recipeId, $ingredientId, $quantity, $unit);

        $ingredient = Ingredient::getIngredientById($ingredientId);
        $ingredientMacronutrients = Ingredient::getIngredientMacronutrients($ingredientId);
        $recipe = Recipe::getRecipeById($recipeId);

        foreach ($ingredientMacronutrients as $macronutrient) {
            $kcalPerGram = Ingredient::getMacronutrientKcalPerGram($macronutrient['name']);
            switch ($macronutrient['name']) {
                case 'Carbohydrate':
                    $recipe->carbohydrate += $macronutrient['quantity']/100 * $quantity;
                    $recipe->energy += $macronutrient['quantity']/100 * $quantity * $kcalPerGram; // Change for value in database
                    break;
                case 'Protein':
                    $recipe->protein += $macronutrient['quantity']/ 100 * $quantity;
                    $recipe->energy += $macronutrient['quantity']/100 * $quantity * $kcalPerGram;
                    break;
                case 'Fat':
                    $recipe->fat += $macronutrient['quantity'] / 100 * $quantity;
                    $recipe->energy += $macronutrient['quantity']/100 * $quantity * $kcalPerGram;
                    break;
            }
            $kcalPerGram = 0;
        }

        $recipe->updateRecipe();

        // Redirect to addIngredients.php
        header("Location: ../pages/addIngredients.php");
        exit();
    }else {
        // Add Ingredient to database
    $ingredientId = Ingredient::addIngredient($name, $carbohydrate, $protein, $fat);
    IngredientRecipe::addIngredientToRecipe($recipeId, $ingredientId, $quantity, $unit);
        // Update recipe energy, carbohydrates, proteins and fats
    // - Get the macronutrients of the ingredient and multiply by the quantity
    // - Add the macronutrients to the recipe
    if ($unit == "kg") {
        $quantity *= 1000;
    } else if ($unit == "L") {
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
                $recipe->energy += $macronutrient['quantity']/100 * $quantity * $kcalPerGram; // Change for value in database
                break;
            case 'Protein':
                $recipe->protein += $macronutrient['quantity']/ 100 * $quantity;
                $recipe->energy += $macronutrient['quantity']/100 * $quantity * $kcalPerGram;
                break;
            case 'Fat':
                $recipe->fat += $macronutrient['quantity'] / 100 * $quantity;
                $recipe->energy += $macronutrient['quantity']/100 * $quantity * $kcalPerGram;
                break;
        }
        $kcalPerGram = 0;
    }

    $recipe->updateRecipe();


    // Redirect to addIngredients.php
    header("Location: ../pages/addIngredients.php");
    }
}?>