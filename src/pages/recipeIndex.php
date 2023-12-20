<?php
require_once(__DIR__ . '/../database/recipe.class.php');
require_once(__DIR__ . '/../views/header.php');
require_once(__DIR__ . '/../views/footer.php');
require_once(__DIR__ . '/../views/recipeIndex.php');
require_once(__DIR__ . '/../views/searchRecipes.php');
require_once(__DIR__ . '/../views/sortRecipes.php');
require_once(__DIR__ . '/../views/filters.php');


// Check if there is a page number in the URL
if (isset($_GET["page"])) {
    $page = intval($_GET["page"]);
    // If the page number is less than 1, set it to 1
    if ($page < 1) {
        $page = 1;
    }
    // If the page number is greater than the last page, set it to the last page
    if ($page > Recipe::getNumberOfPages()) {
        $page = Recipe::getNumberOfPages();
    }
} else {
    $page = 1;
}

// If there is a cookie withthe recipes, use the recipes that match the filters
if (isset($_SESSION["recipes"])) {
    $recipes = $_SESSION["recipes"];
    $showPage = false;
} else {
    $recipes = Recipe::getAllRecipes($page);
    $showPage = true;
}

head("Recipes");
?>
<main class="indexBundle">
<?php 
filters();
searchRecipes();
sortRecipes(); 
recipeIndex($recipes, $page, $showPage);
?>
</main>
<?php
footer();
?>