<?php

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/planRecipe.class.php');

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
    // Why is planRecipesResults an empty array?


    var_dump($planRecipesResults);

    $planRecipes = array();

    foreach ($planRecipesResults as $planRecipe) {
      array_push($planRecipes, new PlanRecipe(
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
   * Get all instances of WeeklyPlan from the db where the idNutritionist is the same as the one passed as parameter
   * 
   * @param PDO $db Database connection
   * @param int $id Id of the nutritionist
   */
  
}

?>