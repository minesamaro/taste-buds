<?php

require_once(__DIR__ . '/../database/connection.db.php');

class CookingTechnique {
    public string $name;
    public int $difficulty;
    public string $methodDescription;

    public function __construct(string $name, int $difficulty, string $methodDescription) {
        $this->name = $name;
        $this->difficulty = $difficulty;
        $this->methodDescription = $methodDescription;
    }

    /**
     * Get all cooking techniques
     * @return array
     */
    static function getAllCookingTechniques(): array
    {
        $db = Database::getDatabase();
        $stmt = $db->prepare('SELECT * FROM CookingTechnique');
        $stmt->execute();
        return $stmt->fetchAll();
    }
}


?>