<?php
declare(strict_types=1);

require_once(__DIR__ . '/ingredient.class.php');
require_once(__DIR__ . '/recipe.class.php');
require_once(__DIR__ . '/../database/connection.db.php');

class IngredientRecipe
{
    public float $quantity;
    public string $measurementUnit;
    public Ingredient $ingredient;
    public Recipe $recipe;

    public function __construct(float $quantity, string $measurementUnit, Ingredient $ingredient, Recipe $recipe)
    {
        $this->quantity = $quantity;
        $this->measurementUnit = $measurementUnit;
        $this->ingredient = $ingredient;
        $this->recipe = $recipe;
    }

    /**
     * Get all ingredients for a specific recipe
     *
     * @param int $recipeId Recipe ID
     * @return array Array of IngredientRecipe objects
     */
    public static function getIngredientsForRecipe(int $recipeId): array
    {
        $db = Database::getDatabase();
        $stmt = $db->prepare(
            'SELECT quantity, measurement_unit, ingredient_id, recipe_id 
            FROM IngredientRecipe 
            WHERE recipe_id = ?'
        );
        
        $stmt->execute(array($recipeId));
        $ingredientsResults = $stmt->fetchAll();

        $ingredientRecipes = array();

        foreach ($ingredientsResults as $ingredientResult) {
            $ingredient = Ingredient::getIngredientById(intval($ingredientResult['ingredient_id']));
            $recipe = Recipe::getRecipeById(intval($ingredientResult['recipe_id']));


            array_push($ingredientRecipes, new IngredientRecipe(
                floatval($ingredientResult['quantity']),
                $ingredientResult['measurement_unit'],
                $ingredient,
                $recipe
            ));
        }

        return $ingredientRecipes;
    }

    /**
     * Add an ingredient to a recipe
     */
    public static function addIngredientToRecipe(int $recipeId, int $ingredientId, float $quantity, string $measurementUnit): void
    {
        $db = Database::getDatabase();
        $stmt = $db->prepare(
            'INSERT INTO IngredientRecipe (quantity, measurement_unit, ingredient_id, recipe_id) 
            VALUES (?, ?, ?, ?)'
        );
        
        $stmt->execute(array($quantity, $measurementUnit, $ingredientId, $recipeId));
    }

    /**
     * Delete an ingredient from a recipe
     */
    public static function deleteIngredientFromRecipe(int $recipeId, int $ingredientId, string $measurementUnit, float $quantity): void
    {
        $db = Database::getDatabase();
        $stmt = $db->prepare(
            'DELETE FROM IngredientRecipe 
            WHERE recipe_id = ? AND ingredient_id = ? AND measurement_unit = ? AND quantity = ?'
        );
        
        $stmt->execute(array($recipeId, $ingredientId, $measurementUnit, $quantity));
    }

    /**
     * Get the ids of the ingredients in a recipe
     */
    public static function getIngredientIdsinRecipe(int $recipeId): array
    {
        $db = Database::getDatabase();
        $stmt = $db->prepare(
            'SELECT ingredient_id 
            FROM IngredientRecipe 
            WHERE recipe_id = ?'
        );
        
        $stmt->execute(array($recipeId));
        $ingredientIds = $stmt->fetchAll();
        $ingredientIds = array_column($ingredientIds,'ingredient_id');

        return $ingredientIds;
    }
}
?>