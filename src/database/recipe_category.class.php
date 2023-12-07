<?php

require_once(__DIR__ . '/../database/connection.db.php');

class RecipeFoodCategory {
    public string $category;
    public int $recipeId;

    public function __construct(string $category, int $recipeId) {
        $this->category = $category;
        $this->recipeId = $recipeId;
    }

    /**
   * Get food categories for a recipe by its ID
   *
   * @param int $recipeId Recipe ID
   * @return array Array of FoodCategory objects
   */
  public static function getRecipeFoodCategories(int $recipeId): array {
    $db = Database::getDatabase();
    $stmt = $db->prepare('
        SELECT category, recipe_id
        FROM RecipeCategory 
        WHERE recipe_id = ?
    ');
    $stmt->execute([$recipeId]);
    $foodCategories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $result = [];
    foreach ($foodCategories as $fc) {
        $result[] = new RecipeFoodCategory($fc['category'], intval($fc['recipe_id']));
    }

    return $result;
  }
}

?>