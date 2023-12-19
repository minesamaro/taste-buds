<?php
declare(strict_types=1);

require_once(__DIR__ . '/../database/connection.db.php');

class Ingredient
{
    public int $id;
    public string $name;

    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * Get an ingredient by ID
     *
     * @param int $id Ingredient ID
     * @return Ingredient
     */
    public static function getIngredientById(int $id): Ingredient
    {
        $db = Database::getDatabase();
        $stmt = $db->prepare(
            'SELECT id, name
            FROM Ingredient
            WHERE id = ?'
        );

        $stmt->execute(array($id));
        $ingredient = $stmt->fetch();

        return new Ingredient(
            intval($ingredient['id']),
            $ingredient['name']
        );
    }

    /**
     * Get all ingredients
     *
     * @return array
     */
    public static function getAllIngredients(): array
    {
        $db = Database::getDatabase();
        $stmt = $db->prepare(
            'SELECT id, name
            FROM Ingredient'
        );

        $stmt->execute();
        $ingredients = $stmt->fetchAll();

        $ingredientsArray = array();
        foreach ($ingredients as $ingredient) {
            array_push(
                $ingredientsArray,
                new Ingredient(
                    intval($ingredient['id']),
                    $ingredient['name']
                )
            );
        }

        return $ingredientsArray;
    }

    /**
     * Get the macronutrients of an ingredient by id
     */
    public static function getIngredientMacronutrients(int $id): array
    {
        $db = Database::getDatabase();
        $stmt = $db->prepare(
            'SELECT im.quantity_g AS quantity, im.macronutrient as name       
                         FROM IngredientMacronutrient im
                         WHERE im.ingredient_id =  ?'
        );

        $stmt->execute(array($id));
        $ingredient = $stmt->fetchAll();

        return $ingredient;
    }

    /**
     * Get the kcal per gram of a macronutrient
     */
    public static function getMacronutrientKcalPerGram(string $macronutrient): float
    {
        $db = Database::getDatabase();
        $stmt = $db->prepare(
            'SELECT kcal_per_gram
                         FROM Macronutrient
                         WHERE name =  ?'
        );

        $stmt->execute(array($macronutrient));
        $kcal = $stmt->fetch();

        return floatval($kcal['kcal_per_gram']);
    }

}
?>