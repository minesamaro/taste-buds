<?php

require_once(__DIR__ . '/../database/connection.db.php');

class RecipeRating
{
    public string $ratingDate;
    public int $ratingValue;
    public ?string $comment;
    public int $userId;
    public int $recipeId;

    // Constructor and other methods as needed

    /**
     * Get RecipeRating by recipe ID - all ratings for one recipe
     *
     * @param int $recipeId
     * @return RecipeRating|null
     */
    static function getRecipeRatingsByRecipeId(int $recipeId): ?RecipeRating  // "?" in case the result is null (no ratings in database)
    {
        $db = Database::getDatabase();
        $stmt = $db->prepare('SELECT * FROM RecipeRating WHERE recipe_id = ?');
        $stmt->execute([$recipeId]);
        $recipeRatingData = $stmt->fetch();

        if (!$recipeRatingData) {
            return null;
        }

        $recipeRatings = array();
        foreach ($recipeRatingData as $rrs) {
        array_push(
            $recipeRatings,
            new RecipeRating(
                $rrs['rating_date'],
                intval($rrs['rating_value']),
                $rrs['comment'],
                intval($rrs['user_id']),
                intval($rrs['recipe_id'])
            )
        );
        }
        return $recipeRatings;
    }

    /**
     * Get RecipeRating by recipe ID and user ID
     *
     * @param int $recipeId
     * @param int $userId
     * @return RecipeRating|null
     */
    static function getRecipeRatingByRecipeAndUser(int $recipeId, int $userId): ?RecipeRating
    {
        $db = Database::getDatabase();
        $stmt = $db->prepare('SELECT * FROM RecipeRating WHERE recipe_id = ? AND user_id = ?');
        $stmt->execute([$recipeId, $userId]);
        $recipeRatingData = $stmt->fetch();

        if (!$recipeRatingData) {
            return null;
        }

        return new RecipeRanking(
            $recipeRatingData['rating_date'],
            intval($recipeRatingData['rating_value']),
            $recipeRatingData['comment'],
            intval($recipeRatingData['user_id']),
            intval($recipeRatingData['recipe_id'])
        );
    }

    /**
     * Get the mean ranking for a specific recipe
     *
     * @param int $recipeId
     * @return float|null
     */
    static function getMeanRatingForRecipe(int $recipeId): float
    {
        $db = Database::getDatabase();
        $stmt = $db->prepare(
            'SELECT AVG(rating_value) AS mean_rating 
            FROM RecipeRating 
            WHERE recipe_id = ?');
        $stmt->execute([$recipeId]);
        $result = $stmt->fetch();

        if (!$result) {
            $result = 0;
        } else {
            $result=floatval($result['mean_rating']);
        }

        return $result;
    }
}

?>