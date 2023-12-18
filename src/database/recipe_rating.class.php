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
    public function __construct(string $ratingDate, int $ratingValue, ?string $comment, int $userId, int $recipeId)
    {
        // Initialize properties in the constructor
        $this->ratingDate = $ratingDate;
        $this->ratingValue = $ratingValue;
        $this->comment = $comment;
        $this->userId = $userId;
        $this->recipeId = $recipeId;
    }

    /**
     * Get RecipeRating by recipe ID - all ratings for one recipe
     *
     * @param int $recipeId
     * @return RecipeRating|null
     */
    
    static function getRecipeRatingsByRecipeId(int $recipeId, ?int $userId): ?array  // "?" in case the result is null (no ratings in database)
    {
        $db = Database::getDatabase();

        $ratings = array();
        $recipeRatingData = array();

        // Check if the user is logged in
        if ($userId) {
            // Retrieve the user's rating for the recipe, if any
            $userRating = self::getRecipeRatingByRecipeAndUser($recipeId, $userId);

            if ($userRating) {
                // If the user has submitted a rating, add it to the list
                array_push($ratings, $userRating);}
            

            $stmt = $db->prepare(
                'SELECT * FROM RecipeRating 
                WHERE recipe_id = ? AND user_id != ?
                ORDER BY rating_date DESC '
            );

            /* $stmt->bindParam(':recipeId', $recipeId, PDO::PARAM_INT);
            $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
            $stmt->arra */
            $stmt->execute(array($recipeId, $userId));
            $recipeRatingData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $userRating = null;

            $stmt = $db->prepare(
                'SELECT * FROM RecipeRating 
                WHERE recipe_id = :recipeId
                ORDER BY rating_date DESC '
            );
            $stmt->bindParam(':recipeId', $recipeId, PDO::PARAM_INT);
            $stmt->execute();
            
            $recipeRatingData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        if (empty($recipeRatingData) && !$userRating) {
            return null;
        }

        foreach ($recipeRatingData as $rrs) {
            array_push( $ratings, new RecipeRating(
                $rrs['rating_date'],
                intval($rrs['rating_value']),
                $rrs['comment'],
                intval($rrs['user_id']),
                intval($rrs['recipe_id'])
            ));
        }
        return $ratings;
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
        $stmt = $db->prepare('SELECT * FROM RecipeRating WHERE recipe_id = :recipeId AND user_id = :userId');
        $stmt->bindParam(':recipeId', $recipeId, PDO::PARAM_INT);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $recipeRatingData = $stmt->fetch();

        if (!$recipeRatingData) {
            return null;
        }

        return new RecipeRating(
            $recipeRatingData['rating_date'],
            intval($recipeRatingData['rating_value']),
            $recipeRatingData['comment'],
            intval($recipeRatingData['user_id']),
            intval($recipeRatingData['recipe_id'])
        );
    }


     /**
     * Get the three most recent ratings for a specific recipe
     *
     * @param int $recipeId
     * @return array
     */
    static function getRecentRatingsForRecipe(int $recipeId, ?int $userId): ?array // "?" in case the result is null (no ratings in database)
    {
        $db = Database::getDatabase();

        $ratings = array();
        $recentRatingsData = array();

        // Check if the user is logged in
        if ($userId) {
            // Retrieve the user's rating for the recipe, if any
            $userRating = self::getRecipeRatingByRecipeAndUser($recipeId, $userId);

            if ($userRating) {
                // If the user has submitted a rating, add it to the list
                array_push($ratings, $userRating);

                $remainingLimit = 2;

                 // Retrieve additional recent ratings to complete the list
                $stmt = $db->prepare(
                    'SELECT * FROM RecipeRating 
                    WHERE recipe_id = :recipeId AND user_id != :userId
                    ORDER BY rating_date DESC 
                    LIMIT :limit'
                );

                $stmt->bindParam(':recipeId', $recipeId, PDO::PARAM_INT);
                $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
                $stmt->bindValue(':limit', $remainingLimit, PDO::PARAM_INT);
                $stmt->execute();
                $recentRatingsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            else {
                $remainingLimit = 3;

                 // Retrieve additional recent ratings to complete the list
                $stmt = $db->prepare(
                    'SELECT * FROM RecipeRating 
                    WHERE recipe_id = :recipeId
                    ORDER BY rating_date DESC 
                    LIMIT :limit'
                );

                $stmt->bindParam(':recipeId', $recipeId, PDO::PARAM_INT);
                $stmt->bindValue(':limit', $remainingLimit, PDO::PARAM_INT);
                $stmt->execute();
                $recentRatingsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } else {

            $remainingLimit = 3;
        
            // Retrieve additional recent ratings to complete the list
            $stmt = $db->prepare(
                'SELECT * FROM RecipeRating 
                WHERE recipe_id = :recipeId
                ORDER BY rating_date DESC 
                LIMIT :limit'
            );

            $stmt->bindParam(':recipeId', $recipeId, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $remainingLimit, PDO::PARAM_INT);
            $stmt->execute();
            $recentRatingsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }



        if (empty($recentRatingsData) && !$userRating) {
            return null; // No ratings for this recipe 
        }

        foreach ($recentRatingsData as $r) {
            array_push( $ratings, new RecipeRating(
                $r['rating_date'],
                intval($r['rating_value']),
                $r['comment'],
                intval($r['user_id']),
                intval($r['recipe_id'])
            ));
        }
        return $ratings;
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
            'SELECT ROUND(AVG(rating_value), 1) AS mean_rating 
            FROM RecipeRating 
            WHERE recipe_id = :recipeId');
        $stmt->bindParam(':recipeId', $recipeId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();

        if (!$result) {
            $result = 0;
        } else {
            $result=floatval($result['mean_rating']);
        }

        return $result;
    }



    public static function addRating(array $ratingData): bool
    {
        $db = Database::getDatabase();
    
        $stmt = $db->prepare(
            'INSERT INTO RecipeRating 
            (rating_value, comment, user_id, recipe_id)
            VALUES (:rating_value, :comment, :user_id, :recipe_id)'
        );
        // without the bindParams
        $stmt->execute(array($ratingData['rating_value'], $ratingData['comment'], $ratingData['user_id'], $ratingData['recipe_id']));
    
        // Bind parameters
        $stmt->bindParam(':rating_value', $ratingData['rating_value'], PDO::PARAM_INT);
        $stmt->bindParam(':comment', $ratingData['comment'], PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $ratingData['user_id'], PDO::PARAM_INT);
        $stmt->bindParam(':recipe_id', $ratingData['recipe_id'], PDO::PARAM_INT);
    
        // Execute the query
        return $stmt->execute();
    }

    /**
     * Check if a user has already rated a specific recipe
     *
     * @param int $userId
     * @param int $recipeId
     * @return bool
     */
    static function checkUserRecipeRating(int $userId, int $recipeId): bool
    {
        $db = Database::getDatabase();
        $stmt = $db->prepare('SELECT COUNT(*) FROM RecipeRating WHERE user_id = :userId AND recipe_id = :recipeId');
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':recipeId', $recipeId, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        return $count > 0;
    }
}

?>