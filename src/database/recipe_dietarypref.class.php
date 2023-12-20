<?php

require_once(__DIR__ . '/../database/connection.db.php');

class RecipeDietaryPref {
    public string $dietaryPref;
    public int $recipeId;

    public function __construct(string $dietaryPref, int $recipeId) {
        $this->dietaryPref = $dietaryPref;
        $this->recipeId = $recipeId;
    }


    /**
   * Get dietary preferences for a recipe by its ID
   *
   * @param int $recipeId Recipe ID
   * @return array Array of RecipeDietaryPref objects
   */
  public static function getRecipeDietaryPreferences(int $recipeId): array {
    $db = Database::getDatabase();
    $stmt = $db->prepare('
        SELECT dietary_pref, recipe_id
        FROM RecipeDietaryPref
        WHERE recipe_id = ?
    ');
    $stmt->execute([$recipeId]);
    $dietaryPreferences = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $result = [];
    foreach ($dietaryPreferences as $dp) {
        $result[] = new RecipeDietaryPref($dp['dietary_pref'], intval($dp['recipe_id']));
    }

    return $result;
  }    

    static function addRecipePreferences(int $recipeId, array $preferences) {
        $db = Database::getDatabase();
        $stmt = $db->prepare('INSERT INTO RecipeDietaryPref (dietary_pref, recipe_id) VALUES (?, ?)');
        foreach ($preferences as $preference) {
            $stmt->execute(array($preference, $recipeId));
        }
    }

    static function addNewRecipePreference(int $recipeId, string $newPreference) {
        $db = Database::getDatabase();
        $stmt = $db->prepare('INSERT INTO DietaryPreference (name) VALUES (?)');
        $stmt->execute(array($newPreference));

        self::addRecipePreferences($recipeId, array($newPreference));
    }

    /**
     * Get all dietary preferences
     * @return array
     */
    static function getAllDietaryPreferences(): array {
        $db = Database::getDatabase();
        $stmt = $db->prepare('SELECT name FROM DietaryPreference');
        $stmt->execute();
        $preferences = $stmt->fetchAll();

        $prefName = array();
        foreach ($preferences as $preference) {
            array_push($prefName, $preference['name']);
        }
        return $prefName;
    }

}

?>