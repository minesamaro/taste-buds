<?php

declare(strict_types=1);

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/planRecipe.class.php');
require_once(__DIR__ . '/recipe.class.php');

class WeeklyPlan
{
  public int $id;
  public string $creationDate;
  public float $totalKcal;
  public int $idNutritionist;
  public int $idCommonUser;

  public array $planRecipes;

  
  public function __construct(int $id, string $creationDate, float $totalKcal, int $idNutritionist, int $idCommonUser)
  {
    $this->id = $id;
    $this->creationDate = $creationDate;
    $this->totalKcal = $totalKcal;
    $this->idNutritionist = $idNutritionist;
    $this->idCommonUser = $idCommonUser;
  }

  /**
   * Get a weekly plan from the db by id
   * 
   * @param PDO $db Database connection
   * @param int $id Id of the weekly plan
   */
  static function getWeeklyPlan(int $id): WeeklyPlan
  {
    $db = Database::getDatabase();
    $stmt = $db->prepare(
      'SELECT id, creation_date, total_kcal, nutritionist_id, common_user_id
        FROM WeeklyPlan
        WHERE id = ?'
    );

    $stmt->execute(array($id));

    $weeklyPlan = $stmt->fetch();

    $plan = new WeeklyPlan(
      intval($weeklyPlan['id']),
      $weeklyPlan['creation_date'],
      floatval($weeklyPlan['total_kcal']),
      intval($weeklyPlan['nutritionist_id']),
      intval($weeklyPlan['common_user_id'])
    );
    $plan->planRecipes = WeeklyPlan::getPlanRecipes($id);

    return $plan;
  }

  /**
   * Get all instances of PlanRecipe where the plan id is the same as the one passed as parameter
   * 
   * @param PDO $db Database connection
   * @param int $id Id of the weekly plan
   */

  static function getPlanRecipes(int $id): array
  {
    $db = Database::getDatabase();
    $stmt = $db->prepare(
      'SELECT recipe_id, plan_id, day_week, time_meal, portion
        FROM PlanRecipe
        WHERE plan_id = ?'
    );


    $stmt->execute(array($id));

    $planRecipesResults = $stmt->fetchAll();

    $planRecipes = array();

    foreach ($planRecipesResults as $planRecipe) {
      array_push(
        $planRecipes,
        new PlanRecipe(
          intval($planRecipe['plan_id']),
          intval($planRecipe['recipe_id']),
          $planRecipe['day_week'],
          floatval($planRecipe['portion']),
          $planRecipe['time_meal'],
        )
      );
    }

    return $planRecipes;
  }

  function getPlanRecipesByDay(string $dayWeek): array
  {
    $db = Database::getDatabase();
    $stmt = $db->prepare(
      'SELECT recipe_id, plan_id, day_week, time_meal, portion
        FROM PlanRecipe
        WHERE plan_id = ? AND day_week = ?'
    );
    $stmt->execute(
      array(
        $this->id,
        $dayWeek
      )
    );
    $planRecipesResults = $stmt->fetchAll();

    $planRecipes = array();
    foreach ($planRecipesResults as $planRecipe) {
      array_push(
        $planRecipes,
        new PlanRecipe(
          intval($planRecipe['plan_id']),
          intval($planRecipe['recipe_id']),
          $planRecipe['day_week'],
          floatval($planRecipe['portion']),
          $planRecipe['time_meal'],
        )
      );
    }
    return $planRecipes;
  }
  

  /**
   * Add a weekly plan to the db
   */
  static function addWeeklyPlan(int $idNutritionist, int $idCommonUser): int
  {
    $db = Database::getDatabase();
    $stmt = $db->prepare(
      'INSERT INTO WeeklyPlan (creation_date, total_kcal, nutritionist_id, common_user_id)
        VALUES (?, ?, ?, ?)'
    );

    $stmt->execute(array(date("Y-m-d"), 0, $idNutritionist, $idCommonUser));

    // Return the id of the last inserted weekly plan by that nutritionist
    $stmt = $db->prepare(
      'SELECT id
        FROM WeeklyPlan
        WHERE nutritionist_id = ?
        ORDER BY id DESC
        LIMIT 1'
    );

    $stmt->execute(array($idNutritionist));

    $weeklyPlan = $stmt->fetch();
    return intval($weeklyPlan['id']);
  }

  /**
   * Delete a Recipe from the WeeklyPlan
   */
  static function deleteRecipeFromWeeklyPlan(int $planId, int $recipeId)
  {
    $db = Database::getDatabase();
    $stmt = $db->prepare(
      'DELETE FROM PlanRecipe
        WHERE plan_id = ? AND recipe_id = ?'
    );

    $stmt->execute(array($planId, $recipeId));
  }

  /**
   * Update the total kcal of a weekly plan
   */
  static function updateWeeklyPlan(int $planId, int $recipeId, float $portion, bool $remove=False)
  {
    $energy = (Recipe::getRecipeById($recipeId))->energy;
    $portion = (PlanRecipe::getPlanRecipe($planId, $recipeId))->portion;
    $energyPortion = $energy * $portion;
    if($remove) $energyPortion = -$energyPortion;
    $totalKcal = (WeeklyPlan::getWeeklyPlan($planId))->totalKcal + $energyPortion;

    $db = Database::getDatabase();
    $stmt = $db->prepare(
      'UPDATE WeeklyPlan
        SET total_kcal = ?
        WHERE id = ?'
    );

    $stmt->execute(array($totalKcal, $planId));
  }
  
  static function getNutriFromPlanId(int $planId): int
  {
    $db = Database::getDatabase();
    $stmt = $db->prepare(
      'SELECT nutritionist_id
        FROM WeeklyPlan
        WHERE id = ?'
    );

    $stmt->execute(array($planId));

    $weeklyPlan = $stmt->fetch();
    return intval($weeklyPlan['nutritionist_id']);
  }

  /**
   * Check if the user is the nutritionist or the common user of the plan
   */
  static function checkPlanUser(int $planId, int $userId): bool
  {
    $db = Database::getDatabase();
    $stmt = $db->prepare(
      'SELECT nutritionist_id, common_user_id
        FROM WeeklyPlan
        WHERE id = ?'
    );

    $stmt->execute(array($planId));

    $weeklyPlan = $stmt->fetch();
    return (intval($weeklyPlan['nutritionist_id']) == $userId || intval($weeklyPlan['common_user_id']) == $userId);
  }
}

?>