<?php
require_once(__DIR__ . '/../database/person.class.php');
require_once(__DIR__ . '/../database/recipe.class.php');
require_once(__DIR__ . '/../database/recipe_rating.class.php');


function profileRatings()
{
    if(isset($_GET['user_id'])) {
 
        $user_id = $_GET['user_id'];
        $isUser=FALSE;
        if(isset($_SESSION['user_id']) and $_SESSION['user_id']==$user_id) {
        
            $isUser=TRUE;}
  
    }
    else {
        $user_id=$_SESSION['user_id'] ;
        $isUser=TRUE;
    }
    
    $ratings=RecipeRating::getAllRatingsByUser($user_id);
    
    $user=Person::getPersonById($user_id);

?>
    
    <article class="content">
        <h2><?php echo $user->first_name ?>'s Ratings</h2>
        <?php 
        if (count($ratings) == 0) { ?>
            <h4>No ratings found</h4> </article>
        <?php }
        else{
        foreach ($ratings as $rating) { 
            $recipeId = $rating->recipeId;
            
            
            $recipe=Recipe::getRecipeById($recipeId);
        ?> 
            <div class="card">
                        
                    <div class="rating-text">
                        <div class="rating-top">
                            <a id="rating-name" href="../pages/recipe.php?recipe_id=<?php echo $recipeId; ?>"><? echo $recipe->name; ?></a>
                            <div class="rating-stars">
                                <?php for ($i = 0; $i < $rating->ratingValue; $i++) { ?>
                                    <span class="">&#x2605</span>
                                <?php } 
                                for ($i = 0; $i < 5 - $rating->ratingValue; $i++) { ?>
                                    <span class="">&#x2606</span>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="rating-bottom">
                            <div>
                            <img class="rating-profile_photo" src="<?php echo $user->profile_photo; ?>" alt="<?php echo $user->username; ?>'s profile photo">
                            <span class="recipe-rating_username"> <? echo $user->username; ?> </span>
                            </div>
                            <div>
                            <span class="recipe-rating_date"> <? echo date("d-m-Y", strtotime($rating->ratingDate)); ?> </span>
                            </div>
                        </div>
                        <div class="rating-comment">
                            <span class="recipe-rating_comment"> <? echo $rating->comment; ?> </span>
                        </div>
                    </div>
            </div>
        <?php } 
        ?> 
        </article>
    <?php }
    }
?>