<?php
declare(strict_types=1);

require_once(__DIR__ . '/../database/connection.db.php');

class RecipeCategory
{
    public string $category;
    public int $id;

    public function __construct(int $id, string $name)
    {
        $this->category = $name;
        $this->id = $id;
    }

    /**
     * Get the category from the recipe id
     *
     * @param int $id recipe ID
     * @return RecipeCategory
     */
    public static function getCategoryByRecipeId(int $id): RecipeCategory
    {
        $db = Database::getDatabase();
        $stmt = $db->prepare(
            'SELECT category
            FROM RecipeCategory
            WHERE id = ?'
        );

        $stmt->execute(array($id));
        $category = $stmt->fetch();

        return new RecipeCategory(
            intval($category['id']),
            $category['category']
        );
    }

    /**
     * Get all categorie names
     *
     * @return string[]
     */
    public static function getAllCategories(): array
    {
        $db = Database::getDatabase();
        $stmt = $db->prepare(
            'SELECT DISTINCT category
            FROM RecipeCategory'
        );

        $stmt->execute();
        $categories = $stmt->fetchAll();

        $categoryNames = array();
        foreach ($categories as $category) {
            array_push($categoryNames, $category['category']);
        }

        return $categoryNames;
    }

    /**
     * Get all dietary peferences
     *
     * @return string[]
     */
    public static function getAllDietaryPreferences(): array
    {
        $db = Database::getDatabase();
        $stmt = $db->prepare(
            'SELECT DISTINCT dietary_pref
            FROM RecipeDietaryPref'
        );

        $stmt->execute();
        $categories = $stmt->fetchAll();

        $categoryNames = array();
        foreach ($categories as $category) {
            array_push($categoryNames, $category['dietary_pref']);
        }

        return $categoryNames;
    }

    /**
     * Add a category to the database and to a recipe
     */
    static function addRecipeCategories(int $recipeId, array $categories) {
        $db = Database::getDatabase();
        foreach ($categories as $categoryName) {
            $stmt = $db->prepare('INSERT INTO RecipeCategory (recipe_id, category) VALUES (?, ?)');
            $stmt->execute(array($recipeId, $categoryName));
        }
    }


    /**
     * Add a new category to the database and to a recipe
     */
    static function addNewRecipeCategories(int $recipeId, string $newCategory) {
        $db = Database::getDatabase();
        $stmt = $db->prepare('INSERT INTO FoodCategory (name) VALUES (?)');
        $stmt->execute(array($newCategory));

        self::addRecipeCategories($recipeId, array($newCategory));

    }


         
    
}

?>