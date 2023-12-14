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



}
?>