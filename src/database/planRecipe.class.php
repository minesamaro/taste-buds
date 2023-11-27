<?php
  declare(strict_types = 1);

  class PlanRecipe {
    public int $recipeId;
    public int $planId;
    public string $dayWeek;
    public string $timeMeal;
    public float $portion;

    public function __construct(int $planId, int $recipeId, string $dayWeek, float $portion, string $timeMeal) {
        $this->planId = $planId;
        $this->recipeId = $recipeId;
        $this->dayWeek = $dayWeek;
        $this->timeMeal = $timeMeal;
        $this->portion = $portion;
    }

    static function getRecipes(int $planId) : array {
      $db = Database::getDatabase();
      $stmt = $db->prepare(
        'SELECT recipe_id, plan_id, day_week, time_meal, portion
        FROM PlanRecipe
        WHERE plan_id = ?');

      $stmt->execute(array($planId));

      $planRecipes = $stmt->fetch();

      $recipes = array();

      foreach ($planRecipes as $planRecipe) {
        $recipe = Recipe::getRecipeById(intval($planRecipe['recipe_id']));
        $recipe->dayWeek = $planRecipe['day_week'];
        $recipe->timeMeal = $planRecipe['time_meal'];
        $recipe->portion = floatval($planRecipe['portion']);
        array_push($recipes, $recipe);
      }

      return $recipes;
    }   
}

?>