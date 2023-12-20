<?php

require_once(__DIR__ . '/../database/connection.db.php');

class RecipeCookingTechnique {
    public int $recipeId;
    public string $cookingTechnique;

    public function __construct(int $recipeId, string $cookingTechnique) {
        $this->recipeId = $recipeId;
        $this->cookingTechnique = $cookingTechnique;
    }

    /**
   * Get cooking techniques for a recipe by its ID
   *
   * @param int $recipeId Recipe ID
   * @return array Array of CookingTechnique objects
   */
  public static function getRecipeCookingTechniques(int $recipeId): array {
    $db = Database::getDatabase();
    $stmt = $db->prepare('
        SELECT recipe_id, cooking_technique
        FROM RecipeCookingTechnique
        WHERE recipe_id = ?
    ');
    $stmt->execute([$recipeId]);
    $cookingTechniques = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $result = [];
    foreach ($cookingTechniques as $ct) {
        $result[] = new RecipeCookingTechnique(intval($ct['recipe_id']), $ct['cooking_technique']);
    }

    return $result;
  }
}
?>


