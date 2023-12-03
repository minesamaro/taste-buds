<?php

require_once(__DIR__ . '/../database/recipe.class.php');

class PlanRecipe
{
    public int $recipeId;
    public int $planId;
    public string $dayWeek;
    public string $timeMeal;
    public float $portion;

    public Recipe $recipe;

    public function __construct(int $planId, int $recipeId, string $dayWeek, float $portion, string $timeMeal)
    {
        $this->planId = $planId;
        $this->recipeId = $recipeId;
        $this->dayWeek = $dayWeek;
        $this->timeMeal = $timeMeal;
        $this->portion = $portion;

        $this->recipe = Recipe::getRecipeById($recipeId);
    }

    static function getRecipe(int $planId): array
    {
        $db = Database::getDatabase();
        $stmt = $db->prepare(
            'SELECT recipe_id, plan_id, day_week, time_meal, portion
        FROM PlanRecipe
        WHERE plan_id = ?'
        );

        $stmt->execute(array($planId));

        $planRecipe = $stmt->fetch();

        $recipe = Recipe::getRecipeById(intval($planRecipe['recipe_id']));
        array_push($recipes, $recipe);

        return $recipes;
    }

    static function addPlanRecipe(int $planId, int $recipeId, string $dayWeek, float $portion, string $timeMeal)
    {
        $db = Database::getDatabase();
        $stmt = $db->prepare(
            'INSERT INTO PlanRecipe (plan_id, recipe_id, day_week, portion, time_meal)
            VALUES (?, ?, ?, ?, ?)'
        );

        $stmt->execute(array($planId, $recipeId, $dayWeek, $portion, $timeMeal));
    }

    static function getPlanRecipe(int $planId, int $recipeId): PlanRecipe
    {
        $db = Database::getDatabase();
        $stmt = $db->prepare(
            'SELECT recipe_id, plan_id, day_week, time_meal, portion
        FROM PlanRecipe
        WHERE plan_id = ? AND recipe_id = ?'
        );

        $stmt->execute(array($planId, $recipeId));

        $planRecipe = $stmt->fetch();

        return new PlanRecipe(
            intval($planRecipe['plan_id']),
            intval($planRecipe['recipe_id']),
            $planRecipe['day_week'],
            floatval($planRecipe['portion']),
            $planRecipe['time_meal'],
        );
    }
}

?>