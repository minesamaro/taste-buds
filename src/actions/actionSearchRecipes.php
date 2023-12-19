<?php
require_once(__DIR__ . '/../database/recipe.class.php');

session_start();


function getIntersection($array1, $array2) {
    $intersection = array_filter($array1, function($obj1) use ($array2) {
        return array_filter($array2, function($obj2) use ($obj1) {
            return $obj1->id == $obj2->id;
        });
    });

    return array_values($intersection);
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $searchQuery = $_GET['search'] ?? '';
    $_SESSION['isRecipeSearch'] = $searchQuery ?? false;

    // Perform the search using the $searchQuery
    $recipes = Recipe::searchRecipes($searchQuery);

    if (isset($_SESSION["isRecipesFiltered"]) && isset($_SESSION["recipes"])) {
        $filteredRecipes = $_SESSION["recipes"];
        $intersection = getIntersection($people, $filteredPeople);                
        $_SESSION["recipes"] = $intersection;
    } else {
        $_SESSION["recipes"] = $recipes;
    }

    // Redirect to the peopleIndex page after the search
    header("Location: ../pages/recipeIndex.php?searchy=" . urlencode($searchQuery));
    exit();
} else {
    echo "Form not submitted.";
}
?>