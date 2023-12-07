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

    # nao sei se isto deva ficar aqui ou no ficheiro das funcoes (o msm para as outras classes)
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
        $db = Database::getDatabase();
        $stmt = $db->prepare('SELECT * FROM CookingTechnique');
        $stmt->execute();
        return $stmt->fetchAll();
    }
}


?>