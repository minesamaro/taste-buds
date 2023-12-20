<?php
require_once(__DIR__ . '/../database/nutritionist_approval.class.php');
require_once(__DIR__ . '/../database/person.class.php');

function addNutriApproval($recipe_id, $user_id)
{
    $isRecipeApproved = NutritionistApproval::isApproved($recipe_id);
    // Check if the recipe has not been approved by anyone yet
    if (!$isRecipeApproved) {
        // Show the approval form for nutri to fill when logged in
        if (isset($_SESSION['user_id']) && Person::isNutritionist($user_id)) {
            ?>
            <h2 id="recipe-add_approval">Approve this recipe</h2>
            <form action="recipe-approve-recipe" method="POST">
                <input type="hidden" name="recipe_id" value="<?php echo $recipe_id; ?>">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <button type="submit">Submit Approval</button>
            </form>
            <?php
        }
    }
}
?>
