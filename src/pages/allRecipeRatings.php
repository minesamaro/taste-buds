<?php
require_once(__DIR__ . '/../views/header.php');
require_once(__DIR__ . '/../database/recipe_rating.class.php');
require_once(__DIR__ . '/../database/person.class.php');
require_once(__DIR__ . '/../database/recipe.class.php');

// Everyone can see the ratings of a recipe, so no permissions are needed
// Retrieve recipe ID from the URL
$recipeId = $_GET['recipe_id'] ?? 1; //change this, is to choose a recipe for now
$recipe = Recipe::getRecipeById($recipeId);
$userId = $_SESSION['user_id'] ?? null; 

// Retrieve all ratings for the specified recipe
$ratings = RecipeRating::getRecipeRatingsByRecipeId($recipeId, $userId);

head($recipe->name . ': All Ratings');
?>

<!DOCTYPE html>
<html lang="en">


<body>
        <h2><?php echo $recipe->name . ': All Ratings (' . count($ratings) . ')'; ?></h2>

        <section class="recipe-all_ratings">
            <?php foreach ($ratings as $rt) :
                $rating_user=Person::getPersonById($rt->userId); ?>
                <div class="rating">
                    <p><?php echo $rating_user->username; ?></p>
                    <p><?php echo $rt->ratingDate; ?></p>
                    <p><?php echo $rt->ratingValue; ?></p>
                    <p><?php echo $rt->comment; ?></p>
                </div>
            <?php endforeach; ?>
        </section>

</body>

</html>