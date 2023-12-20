
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
            <section class="card">
                <div class="card-header">
                    <h4>
                        <a href="../pages/recipe.php?id=<?php echo $recipeId?>"><? echo $recipe->name ?></a>

                    </h4>
                </div>
                    
                    <h6><?php echo $rating->ratingValue ?></h6>
                    <h6><?php echo $rating->ratingDate ?></h6>
                    <h6><?php echo $rating->comment ?></h6>
        
                </div>


            </section>
        <?php } 
        ?> 
        </article>
    <?php }
    }
?>