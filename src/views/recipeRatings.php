<?php
require_once(__DIR__ . '/../database/recipe_rating.class.php');
function recipeRatings($ratings, $all_ratings, $userId, $session_user, $recipeId){ ?>
    <!-- Ratings Section -->
        <section class="recipe-ratings" id="recipe-ratings">
            
            <h2 id="recipe-see_ratings_title">Ratings (<?php
                if ($all_ratings) { 
                    echo count($all_ratings); 
                } else {
                    echo 0;
                } ?>)</h2>

            <?php if($userId) { ?>

                <div class="recipe-see_ratings">
                                    
                <?php 
                if ($ratings) {                
                    foreach ($ratings as $rt) { 
                    $rating_user=Person::getPersonById($rt->userId); ?>
                    <div class="card">
                        <div class="rating-top">

                            <a id="rating-name" href="../pages/profile.php?person_id=<?php echo $rating_user->id; ?>"><? echo $rating_user->first_name . " " . $rating_user->surname; ?></a>
                            <div class="rating-stars">
                                <?php for ($i = 0; $i < $rt->ratingValue; $i++) { ?>
                                    <span class="">&#x2605</span>
                                <?php } 
                                for ($i = 0; $i < 5 - $rt->ratingValue; $i++) { ?>
                                    <span class="">&#x2606</span>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="rating-bottom">
                            <div>
                            <img class="rating-profile_photo" src="<?php echo $rating_user->profile_photo; ?>" alt="<?php echo $rating_user->username; ?>'s profile photo">
                            <span class="recipe-rating_username"> <? echo $rating_user->username; ?> </span>
                            </div>
                            <div>
                            <span class="recipe-rating_date"> <? echo date("d-m-Y", strtotime($rt->ratingDate)); ?> </span>
                            </div>
                        </div>
                        <div class="rating-comment">
                            <span class="recipe-rating_comment"> <? echo $rt->comment; ?> </span>
                        </div>
                        <?php if ($session_user->id == $rating_user->id) { ?>
                        <div class="rating-delete">
                            <form action="../actions/actionDeleteRecipeRating.php" method="post">
                                <input type="hidden" name="recipeId" value="<?php echo $recipeId; ?>">
                                <input type="hidden" name="ratingId" value="<?php echo $rt->userId; ?>">
                                <button type="submit" class="deleteBt">Delete</button>
                            </form>
                        </div>
                        <?php } ?>
                    </div>
                <? } 
                ?>
                <a id="recipe_all_ratings" href="../pages/allRecipeRatings.php"><button>See all ratings</button></a> 
                <?php }

                if(!$ratings) {
                    echo "No ratings yet";
                } ?>

                </div>

                <?php if (!RecipeRating::checkUserRecipeRating($userId, $recipeId)) { ?>
                <div class="recipe-write_rating">
                    <h2 id="recipe-write_rating_title">Rate this recipe</h2>
                    <div class="card">
                        <form id="recipe_write_rating" action="../actions/action_write_recipe_rating.php" method="post"> 
                            <div id="rating-name"> <? echo $session_user->first_name . " " . $session_user->surname; ?> </div>
                            <input type="hidden" name="recipe-write_rating_recipe_id" value="<?php echo $recipeId; ?>">

                            <div class="form-group" id="form-recipe_rating">
                            <fieldset class="star-rating">
                                <input checked name="recipe-write_rating_value" value="0" type="radio" id="rating0">
                                <label for="rating0">
                                    <span class="hide-visually">0 Stars</span>
                                </label>

                                <input name="recipe-write_rating_value" value="1" type="radio" id="rating1">
                                <label for="rating1">
                                    <span class="hide-visually">1 Star</span>
                                    <span aria-hidden="true" class="star">★</span>
                                </label>

                                <input name="recipe-write_rating_value" value="2" type="radio" id="rating2">
                                <label for="rating2">
                                    <span class="hide-visually">2 Stars</span>
                                    <span aria-hidden="true" class="star">★</span>
                                </label>

                                <input name="recipe-write_rating_value" value="3" type="radio" id="rating3">
                                <label for="rating3">
                                    <span class="hide-visually">3 Stars</span>
                                    <span aria-hidden="true" class="star">★</span>
                                </label>

                                <input name="recipe-write_rating_value" value="4" type="radio" id="rating4">
                                <label for="rating4">
                                    <span class="hide-visually">4 Stars</span>
                                    <span aria-hidden="true" class="star">★</span>
                                </label>

                                <input name="recipe-write_rating_value" value="5" type="radio" id="rating5">
                                <label for="rating5">
                                    <span class="hide-visually">5 Stars</span>
                                    <span aria-hidden="true" class="star">★</span>
                                </label>
                            </fieldset>
                            </div>

                            <div class="form-group" id="form-recipe_rating_comment">
                                <!-- create a text area for comments -->
                                <textarea class="card-small" id="recipe-write_rating_comment" name="recipe-write_rating_comment" placeholder="Write your comment here..." cols="30" rows="5"></textarea>
                            </div>

                            <button>Submit rating</button>
                        </form>
                    </div>
                </div>
            <?php }} else {
                echo "Log in to see the ratings of this recipe";
            }

           /*  else { ?>

                <div class="recipe-already_user_rated">
                    <h2 id="recipe-already_user_rated_title">Your rating for this recipe</h2>

                    <?php $session_user_rating=RecipeRating::getRecipeRatingByRecipeAndUser($recipeId, $userId); ?>

                    <span class="recipe-rating_username"> <? echo $session_user->username; ?> </span>
                    <span class="recipe-rating_date"> <? echo $session_user_rating->ratingDate; ?> </span>
                    <span class="recipe-rating_value"> <? echo $session_user_rating->ratingValue; ?> </span> 
                    <span class="recipe-rating_comment"> <? echo $session_user_rating->comment; ?> </span>

                </div>
            <?php } ?> */ ?>
        
        </section>

    </div>
<?php } ?>