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
}
?>