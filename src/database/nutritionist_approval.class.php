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
     * Add a new nutritionist approval
     *
     * @param int $recipe_id Recipe ID
     * @param int $nutritionist_id Nutritionist ID
     * @return bool True if the approval was added successfully, false otherwise
     */
    public static function addNutriApproval(int $recipe_id, int $nutritionist_id): bool {
        $db = Database::getDatabase();
        $stmt = $db->prepare(
            'INSERT INTO NutritionistApproval (recipe_id, nutritionist_id)
            VALUES (?, ?)'
        );

        $stmt->execute([$recipe_id, $nutritionist_id]);
        return $stmt->rowCount() > 0; // True if the row was inserted, false otherwise
    }

    /**
     * Delete a nutritionist approval
     *
     * @param int $recipe_id Recipe ID
     * @param int $nutritionist_id Nutritionist ID
     * @return bool True if the approval was deleted successfully, false otherwise
     */
    public static function deleteNutriApproval(int $recipe_id, int $nutritionist_id): bool {
        $db = Database::getDatabase();
        $stmt = $db->prepare(
            'DELETE FROM NutritionistApproval
            WHERE recipe_id = ? AND nutritionist_id = ?'
        );

        $stmt->execute([$recipe_id, $nutritionist_id]);
        return $stmt->rowCount() > 0; // True if the row was deleted, false otherwise
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

    /**
     * Check if a recipe has been approved by a nutritionist
     *
     * @param int $recipe_id Recipe ID
     * @return bool True if the recipe has been approved, false otherwise
     */
    public static function isApproved (int $recipe_id): bool {
        $db = Database::getDatabase();
        $stmt = $db->prepare(
            'SELECT *
            FROM NutritionistApproval
            WHERE recipe_id = ?'
        );
        
        $stmt->execute([$recipe_id]);
        $approvalData = $stmt->fetch();

        if ($approvalData) {
            return true;
        } else {
            return false;
        }

    }
}
?>