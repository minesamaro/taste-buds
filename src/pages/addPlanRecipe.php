<?php
require_once(__DIR__ . '/../views/header.php');
require_once(__DIR__ . '/../views/footer.php');
require_once(__DIR__ . '/../views/addPlanRecipe.php');
require_once(__DIR__ . '/../views/planState.php');
require_once(__DIR__ . '/../database/recipe.class.php');
require_once(__DIR__ . '/../database/weeklyPlan.class.php');
require_once(__DIR__ . '/../database/person.class.php');

if (!isset($_SESSION['user_id']) || !Person::isNutritionist($_SESSION['user_id'])) {
    header("Location: ../pages/404.php");
} else {
    $planId = $_GET['planId'];
    if (!isset($planId) || WeeklyPlan::getNutriFromPlanId($planId) != $_SESSION['user_id']) {
        header("Location: ../pages/404.php");
    }
    else {}

    $plan = WeeklyPlan::getWeeklyPlan(intval($planId));
    $recipes = Recipe::getAllRecipes();

    
    head("Add Recipe");
    ?>
    <main class="planBundle">
    <?php
        addPlanRecipe($recipes, $planId);
        showPlanState($plan);
    ?>
    </main>
    <?php
    footer();
}
?>