<?php

declare(strict_types=1);

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/chef.class.php');
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
  public float $carbohydrates;
  public int $idChef;

  public function __construct(int $id, string $name, int $preparationTime, int $difficulty, int $numberOfServings, string $image, string $preparationMethod, string $submissionDate, float $energy, float $protein, float $fat, float $carbohydrates, int $idChef)
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
    $this->carbohydrates = $carbohydrates;
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

  static function getAllRecipes(): array
  {
    $db = Database::getDatabase();
    $stmt = $db->prepare(
      'SELECT id, name, preparation_time, difficulty, number_of_servings, image, preparation_method, submission_date, energy, protein, fat, carbohydrates, chef
        FROM Recipe'
    );
    $stmt->execute();
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


  public function getChefName(): string
    {
        $chef = Chef::getId($this->id);

        // Check if the chef was found
        if ($chef) {
            return $chef->name;
        }

        // Return a default value or handle the case where the chef is not found
        return 'Unknown Chef';
      }

      public static function getRecipesWithDetailsAndOrder($categories, $techniques, $preferences, $order)
      {
        if ($order == 'recent') {
          $order = 'submission_date';
        } else if ($order == 'review') {
          $order = 'average_ranking';
        } else {
          $order = 'submission_date'; 
        }

        $sql = 'SELECT r.*, AVG(rr.ranking_value) AS average_ranking
        FROM Recipe r
        JOIN RecipeCategory rc ON r.id = rc.recipe_id
        JOIN RecipeDietaryPref rdp ON r.id = rdp.recipe_id
        JOIN RecipeCookingTechnique rct ON r.id = rct.recipe_id
        JOIN RecipeRanking rr ON r.id = rr.recipe_id
        WHERE 1 ';

        $params = array();

        if (!empty($categories)) {
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
  
      $sql .= 'ORDER BY ' . $order . ' DESC';
  
      $db = Database::getDatabase();
      $stmt = $db->prepare($sql);
      $stmt->execute($params);
      
      $recipes = $stmt->fetchAll(); // this is returning less parametrs than it should
     
      $recipesArray = array();
      if (isset($recipes)){
      foreach ($recipes as $recipe) {
        if (isset($recipe['id'])){
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

    public static function getAverageRankingForRecipe($recipeId)
    {
        $db = Database::getDatabase();

        $stmt = $db->prepare('SELECT AVG(ranking_value) AS average_ranking
                              FROM RecipeRanking
                              WHERE recipe_id = ?');
        $stmt->execute([$recipeId]);

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result['average_ranking'] ?? null;
    }
  }
   
  
?>