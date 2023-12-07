<?php

require_once(__DIR__ . '/../database/connection.db.php');

class FoodCategory {
    public string $name;

    public function __construct(string $name) {
        $this->name = $name;
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