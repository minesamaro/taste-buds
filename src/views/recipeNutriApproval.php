<?php
require_once(__DIR__ . '/../database/nutritionist_approval.class.php');
require_once(__DIR__ . '/../database/person.class.php');

function addNutriApproval($recipe_id, $session_user)
{
    $isRecipeApproved = NutritionistApproval::isApproved($recipe_id);
    // Check if the recipe has not been approved by anyone yet
    if (!$isRecipeApproved && $session_user->id) {
        // Show the approval form for nutri to fill when logged in
        
        if(Person::isNutritionist($session_user->id)) {
            ?>
            <div class= "recipe-nutri_approval">
            <h2 id="recipe-add_approval">Approve this recipe</h2>
            <form action="../actions/actionApproveRecipe.php" method="POST">
                <input type="hidden" name="recipe_id" value="<?php echo $recipe_id; ?>">
                <input type="hidden" name="user_id" value="<?php echo $session_user->id; ?>">
                <button type="submit">Submit Approval</button>
            </form>
            </div>
            <?php
        }
        
    }
}

function deleteNutriApproval($recipe_id, $session_user)
{
    $isRecipeApproved = NutritionistApproval::isApproved($recipe_id);
    // Check if the recipe has not been approved by anyone yet
    if ($isRecipeApproved && $session_user->id) {
        $approval = NutritionistApproval::getNutritionistApprovalForRecipe($recipe_id);
        // Show the approval form for nutri to fill when logged in
        if ($session_user->id == $approval->nutritionist_id) {
                ?>
                <div class= "recipe-nutri_approval">
                <h2 id="recipe-delete_approval">You approved this recipe.</h2>
                <form action="../actions/actionDeleteApprovalRecipe.php" method="POST">
                    <input type="hidden" name="recipe_id" value="<?php echo $recipe_id; ?>">
                    <input type="hidden" name="user_id" value="<?php echo $session_user->id; ?>">
                    <button type="submit">Delete Approval</button>
                </form>
                </div>
                <?php
        }
    }
}
?>
