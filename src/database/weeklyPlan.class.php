<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../database/connection.db.php');

  class WeeklyPlan {
    public int $id;
    public string $creationDate;
    public float $totalKcal;
    public int $idNutritionist;
    public int $idCommonUser;

    public function __construct(int $id, string $creationDate, float $totalKcal, int $idNutritionist, int $idCommonUser) {
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
    static function getWeeklyPlan(int $id) : WeeklyPlan {
      $db = Database::getDatabase();
      $stmt = $db->prepare(
        'SELECT id, creation_date, total_kcal, nutritionist_id, common_user_id
        FROM WeeklyPlan
        WHERE id = ?');

      $stmt->execute(array($id));
  
      $weeklyPlan = $stmt->fetch();

      return new WeeklyPlan(
        intval($weeklyPlan['id']), 
        $weeklyPlan['creation_date'],
        floatval($weeklyPlan['total_kcal']),
        intval($weeklyPlan['nutritionist_id']),
        intval($weeklyPlan['common_user_id'])
      );
    }

    /**
     * Get all instances of PlanRecipe where the plan id is the same as the one passed as parameter
     * 
     * @param PDO $db Database connection
     * @param int $id Id of the weekly plan
     */

    static function getPlanRecipes(int $id) : array {
      $db = Database::getDatabase();
      $stmt = $db->prepare(
        'SELECT recipe_id, plan_id, day_week, time_meal
        FROM PlanRecipe
        WHERE plan_id = ?');

      $stmt->execute(array($id));

      $planRecipes = $stmt->fetchAll();

      $planRecipesArray = array();

      foreach ($planRecipes as $planRecipe) {
        array_push($planRecipesArray, new PlanRecipe(
          intval($planRecipe['id']),
          intval($planRecipe['idRecipe']),
          intval($planRecipe['idWeeklyPlan']),
          $planRecipe['day'],
          $planRecipe['meal'],
        ));
      }

      return $planRecipesArray;

  }

    /**
     * Get all instances of WeeklyPlan from the db where the idNutritionist is the same as the one passed as parameter
     * 
     * @param PDO $db Database connection
     * @param int $id Id of the nutritionist
     */
    static function getWeeklyPlansByNutritionist(int $id) : array {
      $db = Database::getDatabase();
      $stmt = $db->prepare(
        'SELECT id, creationDate, totalKcal, idNutritionist, idCommonUser
        FROM WeeklyPlan
        WHERE idNutritionist = ?');

      $stmt->execute(array($id));

      $weeklyPlans = $stmt->fetchAll();

      $weeklyPlansArray = array();

      foreach ($weeklyPlans as $weeklyPlan) {
        array_push($weeklyPlansArray, new WeeklyPlan(
          intval($weeklyPlan['id']), 
          $weeklyPlan['creationDate'],
          floatval($weeklyPlan['totalKcal']),
          intval($weeklyPlan['idNutritionist']),
          intval($weeklyPlan['idCommonUser'])
        ));
      }

      return $weeklyPlansArray;
    }
  }

?>