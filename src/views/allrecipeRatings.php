<?php
require_once(__DIR__ . '/../database/recipe_rating.class.php');
require_once(__DIR__ . '/../database/person.class.php');

function allrecipeRatings($all_ratings, $recipe) { ?>
<main>
    <article class="content">
    <h2><?php echo $recipe->name . ': All Ratings (' . count($all_ratings) . ')'; ?></h2>

        <section class="recipe-all_ratings">
            <?php foreach ($all_ratings as $rt) :
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
                </div>
            <?php endforeach; ?>
        </section>
    </article>
    
<?php } ?>