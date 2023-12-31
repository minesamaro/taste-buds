<?php

declare(strict_types=1);

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/chef.class.php');
require_once(__DIR__ . '/cooking.technique.class.php');
require_once(__DIR__ . '/chef.class.php');
require_once(__DIR__ . '/cooking.technique.class.php');
require_once(__DIR__ . '/recipe.category.class.php');


class Recipe
{
  public int $id;
  public string $name;
  public int $preparationTime;
  public int $difficulty;
  public int $numberOfServings;
  public string $image;
  public string $preparationMethod;
  public string $submissionDate;
  public float $energy;
  public float $protein;
  public float $fat;
  public float $carbohydrate;
  public int $idChef;
  public static int $recipesPerPage = 5;

  public function __construct(int $id, string $name, int $preparationTime, int $difficulty, int $numberOfServings, string $image, string $preparationMethod, string $submissionDate, float $energy, float $protein, float $fat, float $carbohydrate, int $idChef)
  {
    $this->id = $id;
    $this->name = $name;
    $this->preparationTime = $preparationTime;
    $this->difficulty = $difficulty;
    $this->numberOfServings = $numberOfServings;
    $this->image = $image;
    $this->preparationMethod = $preparationMethod;
    $this->submissionDate = $submissionDate;
    $this->energy = $energy;
    $this->protein = $protein;
    $this->fat = $fat;
    $this->carbohydrate = $carbohydrate;
    $this->idChef = $idChef;
  }

  /**
   * Get a weekly plan from the db by id
   * 
   * @param int $id Id of the weekly plan
   */
  static function getRecipeById(int $id): Recipe
  {
    $db = Database::getDatabase();
    $stmt = $db->prepare(
      'SELECT id, name, preparation_time, difficulty, number_of_servings, image, preparation_method, submission_date, energy, protein, fat, carbohydrates, chef
            FROM Recipe
            WHERE id = ?'
    );

    $stmt->execute(array($id));

    $recipe = $stmt->fetch();

    return new Recipe(
      intval($recipe['id']),
      $recipe['name'],
      intval($recipe['preparation_time']),
      intval($recipe['difficulty']),
      intval($recipe['number_of_servings']),
      $recipe['image'],
      $recipe['preparation_method'],
      $recipe['submission_date'],
      floatval($recipe['energy']),
      floatval($recipe['protein']),
      floatval($recipe['fat']),
      floatval($recipe['carbohydrates']),
      intval($recipe['chef'])
    );
  }

  static function getAllRecipes(int $page=0): array
  {
    if ($page == 0) {
      ;
    }
    $db = Database::getDatabase();
    $sql= 'SELECT id, name, preparation_time, difficulty, number_of_servings, image, preparation_method, submission_date, energy, protein, fat, carbohydrates, chef
        FROM Recipe
        ORDER BY submission_date DESC';

    if ($page != 0) {
      $sql .= ' LIMIT ? OFFSET ?';
      $stmt = $db->prepare($sql) ?? throw new Exception("Error Processing Request");
      $stmt->execute(array(self::$recipesPerPage, ($page - 1) * self::$recipesPerPage));
    }
    else {
      $stmt = $db->prepare($sql) ?? throw new Exception("Error Processing Request");
      $stmt->execute();
    }

    $recipes = $stmt->fetchAll();
    $recipesArray = array();
    foreach ($recipes as $recipe) {
      array_push($recipesArray, new Recipe(
        intval($recipe['id']),
        $recipe['name'],
        intval($recipe['preparation_time']),
        intval($recipe['difficulty']),
        intval($recipe['number_of_servings']),
        $recipe['image'],
        $recipe['preparation_method'],
        $recipe['submission_date'],
        floatval($recipe['energy']),
        floatval($recipe['protein']),
        floatval($recipe['fat']),
        floatval($recipe['carbohydrates']),
        intval($recipe['chef'])
      )
      );
    }
    return $recipesArray;
  }

    public static function getRecipesWithDetailsAndOrder($categories, $techniques, $preferences, $order)
      {
        if ($order == 'recent') {
          $order = 'submission_date';
        } else if ($order == 'review') {
          $order = 'average_rating';
        } else {
          $order = 'submission_date'; 
        }

        $sql = 'SELECT
              r.id AS recipe_id,
              r.name AS recipe_name,
              r.preparation_time,
              r.difficulty,
              r.number_of_servings,
              r.image,
              r.preparation_method,
              r.submission_date,
              r.energy,
              r.carbohydrates,
              r.protein,
              r.fat,
              r.chef,
              rc.category,
              rdp.dietary_pref,
              rct.cooking_technique,
              AVG(rr.rating_value) AS average_rating
          FROM
              Recipe r
          LEFT JOIN RecipeCategory rc ON r.id = rc.recipe_id
          LEFT JOIN RecipeDietaryPref rdp ON r.id = rdp.recipe_id
          LEFT JOIN RecipeCookingTechnique rct ON r.id = rct.recipe_id
          LEFT JOIN RecipeRating rr ON r.id= rr.recipe_id
          WHERE 1 ';

        

        $params = array();

        if (!empty($categories)) {
          // Using bindParams() to bind the array of parameters
          $sql .= 'AND rc.category IN (' . implode(',', array_fill(0, count($categories), '?')) . ') ';
          $params = array_merge($params, $categories);
      }

      if (!empty($techniques)) {
          $sql .= 'AND rct.cooking_technique IN (' . implode(',', array_fill(0, count($techniques), '?')) . ') ';
          $params = array_merge($params, $techniques);
      }

      if (!empty($preferences)) {
          $sql .= 'AND rdp.dietary_pref IN (' . implode(',', array_fill(0, count($preferences), '?')) . ') ';
          $params = array_merge($params, $preferences);
      }

      $sql .= 'GROUP BY r.id ';
      $sql .= 'ORDER BY ' . $order . ' DESC';

      $db = Database::getDatabase();
      // Run the query with binded parameters
      $stmt = $db->prepare($sql) ?? throw new Exception("Error Processing Request");
      $stmt->execute($params);
      $recipes = $stmt->fetchAll(); // this is returning less parametrs than it should
      $recipesArray = array();
      if (isset($recipes)){
      foreach ($recipes as $recipe) {

        if (isset($recipe['recipe_id'])){
        array_push($recipesArray, new Recipe(
          intval($recipe['recipe_id']),
          $recipe['recipe_name'],
          intval($recipe['preparation_time']),
          intval($recipe['difficulty']),
          intval($recipe['number_of_servings']),
          $recipe['image'],
          $recipe['preparation_method'],
          $recipe['submission_date'],
          floatval($recipe['energy']),
          floatval($recipe['protein']),
          floatval($recipe['fat']),
          floatval($recipe['carbohydrates']),
          intval($recipe['chef'])
        )
        );
      }
    }

    return $recipesArray;
  }
}
  
      public function getCategories(): array
      {
          $db = Database::getDatabase();
          $stmt = $db->prepare(
              'SELECT category
              FROM RecipeCategory
              WHERE recipe_id = ?'
          );
          $stmt->execute(array($this->id));
          $category = $stmt->fetchAll();
          $categoriesArray = array();
          foreach ($category as $category) {
              array_push($categoriesArray, $category['category']);
          }
          return $category; 
      }
      public function getTechniques(): array
      {
          $db = Database::getDatabase();
          $stmt = $db->prepare(
              'SELECT cooking_technique
              FROM RecipeCookingTechnique
              WHERE recipe_id = ?'
          );
          $stmt->execute(array($this->id));
          $techniques = $stmt->fetchAll();
          $techniquesArray = array();
          foreach ($techniques as $technique) {
              array_push($techniquesArray, $technique['cooking_technique']);
          }
          return $techniquesArray;
      }
      public function getPreferences(): array
      {
          $db = Database::getDatabase();
          $stmt = $db->prepare(
              'SELECT dietary_pref
              FROM RecipeDietaryPref
              WHERE recipe_id = ?'
          );
          $stmt->execute(array($this->id));
          $preferences = $stmt->fetchAll();
          $preferencesArray = array();
          foreach ($preferences as $preference) {
              array_push($preferencesArray, $preference['dietary_pref']);
          }
          return $preferencesArray;
      }
  
      public static function getAverageRatingForRecipe($recipeId)
      {
          $db = Database::getDatabase();
  
          $stmt = $db->prepare('SELECT AVG(rating_value) AS average_rating
                                FROM RecipeRating
                                WHERE recipe_id = ?');
          $stmt->execute([$recipeId]);
  
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
  
          return $result['average_rating'] ?? null;
      }
  
    /**
     * Insert a new recipe into the database
     * 
     * @param array $recipeData Associative array containing recipe data
     * @return bool True if successful, false otherwise
     */
    public static function insertRecipe(array $recipeData): bool
    {
      $db = Database::getDatabase();
  
      $stmt = $db->prepare(
        'INSERT INTO Recipe 
         (name, preparation_time, difficulty, number_of_servings, image, preparation_method, submission_date, energy, protein, fat, carbohydrates, chef)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
      );
  
      $values = [
        $recipeData['name'],
        $recipeData['preparationTime'],
        $recipeData['difficulty'],
        $recipeData['numberOfServings'],
        $recipeData['image'],
        $recipeData['preparationMethod'],
        $recipeData['submissionDate'],
        $recipeData['energy'],
        $recipeData['protein'],
        $recipeData['fat'],
        $recipeData['carbohydrates'],
        $recipeData['idChef'],
      ];
  
      return $stmt->execute($values);
    }

  /**
   * Add a new recipe to the database
   */
  static function addRecipe(string $name, int $preparationTime, int $difficulty, int $numberOfServings, string $image, string $preparationMethod, int $idChef): int
  {
    $db = Database::getDatabase();
    $stmt = $db->prepare(
      'INSERT INTO Recipe (name, preparation_time, difficulty, number_of_servings, image, preparation_method, chef)
        VALUES (?, ?, ?, ?, ?, ?, ?)'
    );
    $stmt->execute(
      array(
        $name,
        $preparationTime,
        $difficulty,
        $numberOfServings,
        $image,
        $preparationMethod,
        $idChef
      )
    );
    return intval($db->lastInsertId());
  }

  /**
   * Get the last recipe id from the database
   */
  static function getLastRecipeId(): int
  {
    $db = Database::getDatabase();
    $stmt = $db->prepare(
      'SELECT id
        FROM Recipe
        ORDER BY id DESC
        LIMIT 1'
    );
    $stmt->execute();
    $result = $stmt->fetch();
    return intval($result['id']);
  
  }

  /**
   * Check if user is the author of the recipe
   */
  static function isAuthor(int $recipeId, int $userId): bool
  {
    $db = Database::getDatabase();
    $stmt = $db->prepare(
      'SELECT chef
        FROM Recipe
        WHERE id = ?'
    );
    $stmt->execute(array($recipeId));
    $result = $stmt->fetch();
    return intval($result['chef']) === $userId;
  }

  /**
   * Update the recipe in the database
   */
  public function updateRecipe(): bool
  {
    $db = Database::getDatabase();
    $stmt = $db->prepare(
      'UPDATE Recipe
        SET name = ?, preparation_time = ?, difficulty = ?, number_of_servings = ?, image = ?, preparation_method = ?, submission_date = ?, energy = ?, protein = ?, fat = ?, carbohydrates = ?, chef = ?
        WHERE id = ?'
    );
    return $stmt->execute(
      array(
        $this->name,
        $this->preparationTime,
        $this->difficulty,
        $this->numberOfServings,
        $this->image,
        $this->preparationMethod,
        $this->submissionDate,
        $this->energy,
        $this->protein,
        $this->fat,
        $this->carbohydrate,
        $this->idChef,
        $this->id
      )
    );
  }
  public static function getAllRecipesFromChef($user_id): array
  {
    $db = Database::getDatabase();
    $stmt = $db->prepare(
      'SELECT id, name, preparation_time, difficulty, number_of_servings, image, preparation_method, submission_date, energy, protein, fat, carbohydrates
        FROM Recipe
        WHERE chef=?'
    );
    $stmt->execute(array($user_id));
    $recipes = $stmt->fetchAll();
    $recipesArray = array();
    foreach ($recipes as $recipe) {
      array_push($recipesArray, new Recipe(
        intval($recipe['id']),
        $recipe['name'],
        intval($recipe['preparation_time']),
        intval($recipe['difficulty']),
        intval($recipe['number_of_servings']),
        $recipe['image'],
        $recipe['preparation_method'],
        $recipe['submission_date'],
        floatval($recipe['energy']),
        floatval($recipe['protein']),
        floatval($recipe['fat']),
        floatval($recipe['carbohydrates']),
        $user_id
      )
      );
    }
    return $recipesArray;
  }


  /**
   * Search in the recipes table for recipes that match the search query either on chef or nutri or technique or category or preference
   */
  public static function searchRecipes($searchQuery): array
        {
          $searchQuery = '%' . $searchQuery . '%';  
          $recipeList = array();
            $db = Database::getDatabase();

            // Use prepared statements to prevent SQL injection
            // Make the like use the % % wildcard
            $stmt = $db->prepare(
                'SELECT DISTINCT r.*
                FROM Recipe r
                JOIN RecipeCategory rc ON r.id = rc.recipe_id
                JOIN RecipeDietaryPref rdp ON r.id = rdp.recipe_id
                JOIN RecipeCookingTechnique rct ON r.id = rct.recipe_id
                WHERE r.name LIKE ? OR r.preparation_method LIKE ? OR rc.category LIKE ?  OR rdp.dietary_pref LIKE ? OR rct.cooking_technique LIKE ?'
            );
            $stmt->execute(array($searchQuery));

            // Fetch the results
            foreach ($stmt->fetchAll() as $recipe) {
                array_push($recipeList, new Recipe(
                    intval($recipe['id']),
                    $recipe['name'],
                    intval($recipe['preparation_time']),
                    intval($recipe['difficulty']),
                    intval($recipe['number_of_servings']),
                    $recipe['image'],
                    $recipe['preparation_method'],
                    $recipe['submission_date'],
                    floatval($recipe['energy']),
                    floatval($recipe['protein']),
                    floatval($recipe['fat']),
                    floatval($recipe['carbohydrates']),
                    intval($recipe['chef'])
                ));
            }

            return $recipeList;
        }

        /**
         * Get the number of pages for the recipes
         */
        public static function getNumberOfPages(): int {
            $db = Database::getDatabase();
            $stmt = $db->prepare(
                'SELECT COUNT(*) AS number_of_recipes
                FROM Recipe'
            );
            $stmt->execute();
            $result = $stmt->fetch();
            return intval(ceil($result['number_of_recipes'] / self::$recipesPerPage));
        }

        
}

?>