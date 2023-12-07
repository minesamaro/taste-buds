<?php

declare(strict_types=1);

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/nutritionist.class.php');
require_once(__DIR__ . '/person.class.php');

class NutritionistApproval
{
    public int $recipe_id;
    public string $approval_date;
    public int $nutritionist_id;

    public function __construct(int $recipe_id, string $approval_date, int $nutritionist_id)
    {
        $this->recipe_id = $recipe_id;
        $this->approval_date = $approval_date;
        $this->nutritionist_id = $nutritionist_id;
    }

    /**
     * Get nutritionist approval for a recipe by ID
     *
     * @param int $recipeId Recipe ID
     * @return NutritionistApproval|null
     */
    public static function getNutritionistApprovalForRecipe(int $recipeId): ?NutritionistApproval
    {
        $db = Database::getDatabase();
        $stmt = $db->prepare(
            'SELECT recipe_id, approval_date, nutritionist_id
            FROM NutritionistApproval
            WHERE recipe_id = ?'
        );

        $stmt->execute([$recipeId]);
        $approvalData = $stmt->fetch();

        if ($approvalData) {
            $nutritionist_id = $approvalData['nutritionist_id'];
            return new NutritionistApproval(
                intval($approvalData['recipe_id']),
                $approvalData['approval_date'],
                $nutritionist_id
            );
        }

        return null; // No nutritionist approval found
    }
}
?>