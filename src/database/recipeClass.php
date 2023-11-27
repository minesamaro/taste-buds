<?php
  declare(strict_types = 1);

  class Recipe {
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

    public function __construct(int $id, string $name, int $preparationTime, int $difficulty, int $numberOfServings, string $image, string $preparationMethod, string $submissionDate, float $energy, float $protein, float $fat, float $carbohydrates, int $idChef) {
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
     * @param PDO $db Database connection
     * @param int $id Id of the weekly plan
     */
    static function getRecipeById(int $id) : Recipe {
        $db = Database::getDatabase();
        $stmt = $db->prepare(
            'SELECT id, name, preparationTime, difficulty, number_of_servings, image, preparation_method, submission_date, energy, protein, fat, carbohydrates, chef
            FROM Recipe
            WHERE id = ?');
    
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
  }
?>