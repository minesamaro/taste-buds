<?php
declare(strict_types=1);

require_once(__DIR__ . '/../database/connection.db.php');

class CookingTechnique
{
    public string $name;
    public int $difficulty;
    public string $methodDescription; 

    public function __construct(string $name, int $difficulty, string $methodDescription)
    {
        $this->name = $name;
        $this->difficulty = $difficulty;
        $this->methodDescription = $methodDescription;
    }


    /**
     * Get all categorie names
     *
     * @return string[]
     */
    public static function getAllTechniques(): array
    {
        $db = Database::getDatabase();
        $stmt = $db->prepare(
            'SELECT DISTINCT name
            FROM CookingTechnique'
        );

        $stmt->execute();
        $categories = $stmt->fetchAll();

        $techniqueNames = array();
        foreach ($categories as $category) {
            array_push($techniqueNames, $category['name']);
        }

        return $techniqueNames;
    }

    static function addCookingTechnique(string $name, int $difficulty, string $methodDescription) : CookingTechnique {
        $db = Database::getDatabase();
        $stmt = $db->prepare('INSERT INTO CoookingTechnique (name, difficulty, method_description) VALUES (?, ?, ?)');
        $stmt->execute(array($name, $difficulty, $methodDescription));
    }

    /**
     * Get all cooking techniques
     * @return array
     */
    static function getAllCookingTechniques(): array
    {
        // TODO check if this can be eliminated
        $db = Database::getDatabase();
        $stmt = $db->prepare('SELECT * FROM CookingTechnique');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Add a cooking technique to the database and to a recipe
     */
    static function addRecipeTechniques(int $recipeId, array $techniques) {
        $db = Database::getDatabase();
        foreach ($techniques as $techniqueName) {
            $stmt = $db->prepare('INSERT INTO RecipeCookingTechnique (recipe_id, cooking_technique) VALUES (?, ?)');
            $stmt->execute(array($recipeId, $techniqueName));
        }
    }

    /**
     * Add a New Cooking Technique to the database
     */
    static function addNewRecipeTechnique(int $recipeId, string $name) {
        $db = Database::getDatabase();
        $stmt = $db->prepare('INSERT INTO CookingTechnique (name) VALUES (?)');
        $stmt->execute(array($name));

        self::addRecipeTechniques($recipeId, array($name));

    }

    
}
?>