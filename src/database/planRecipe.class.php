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
}

?>