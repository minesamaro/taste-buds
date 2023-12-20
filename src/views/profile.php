<?php 
require_once(__DIR__ . '/../database/person.class.php');
require_once(__DIR__ . '/../database/commonUser.class.php');
require_once(__DIR__ . '/../database/chef.class.php');
require_once(__DIR__ . '/../database/nutritionist.class.php');

function Profile(){ 
    if(isset($_GET['person_id'])) {
 
        $user_id = $_GET['person_id'];
        $isUser=FALSE;
        if(isset($_SESSION['user_id']) and $_SESSION['user_id']==$user_id) {
        
            $isUser=TRUE;}
    }
    else{
        
        $user_id=$_SESSION['user_id'] ;
        $isUser=TRUE;
    }
    

    $personUser = Person::getPersonById($user_id);

    if (Person::isChef($user_id)){
        $isChef =True;
        $isNutri=false;
        $isCommon=false;
    }
    elseif(Person::isNutritionist($user_id)){
        $isChef=false;
        $isNutri=true;
        $isCommon=false;
    }
    elseif(Person::isCommonUser($user_id)){
        $isChef=false;
        $isNutri=false;
        $isCommon=true;
        
    }
    
    ?>
    
    <article class="center-content" id="profile">
        <div class="profile-photo">
            <img class="profile-profile_photo card-img" src="<?php echo $personUser->profile_photo; ?>"  alt="Profle Picture" width=100px height=100px>
       
        </div>
        <?php 
        if ($isChef){
            ?>
            <div class="card profile-recipes" id="card-profile_recipes">
                <a href="profileRecipes.php?user_id=<?php echo $personUser->id ?>">All Recipes</a>
            </div>
            
        <?php } 
        elseif($isNutri){
            ?> 
            <div class="card profile-approvals" id="card-profile_approvals">>
                <a href="profileApprovals.php?user_id=<?php echo $personUser->id ?>">Approved Recipes</a>
            </div>
            
        <?php } 
        elseif($isCommon){
            ?> 
            <div class="card profile-ratings" id="card-profile_ratings">
            <a href="profileRatings.php?user_id=<?php echo $personUser->id ?>">Ratings</a>
        </div>
        <?php } 

        if ($isUser){ ?>
        <div class="card profile-update" id="card-profile_update">
                <a href="changeProfile.php">Update Profile</a>
            </div>
            <div class="card profile-changepass" id=card-profile_changepass>
                <a href="changePassword.php">Change Password</a>
            </div>
            <?php } ?>

        <div class="card profile-info">
            <h2>Profile</h2>
            <div class="username">
                <p id="label">Username:</p>
                <p> <?php echo $personUser->username ?></p>
            </div>
            <div class="name">
                <p id="label">First name:</p>
                <p><?php echo $personUser->first_name ?></p>
            </div>
            <div class="surname">
                <p id="label">Surname:</p>
                <p><?php echo $personUser->surname ?></p>
            </div>

            <?php
            //var_dump(Person::isCommonUser($user_id));
            //var_dump($user_id);
            //var_dump(Person::isChef($user_id));
            //var_dump(Person::isNutritionist($user_id));
            // if user is common_user show info, if user is chef or nutri, show formation
            if (Person::isCommonUser($user_id)){
                $commonUser = CommonUser::getCommonUserById($user_id);?>
                <div class="height">
                    <p id="label">Height:</p>
                    <p> <?php echo $commonUser->height ?></p>
                </div> 
                <div class="curr_weight">
                    <p id="label">Current Weight:</p>
                    <p> <?php echo $commonUser->current_weight ?></p>
                </div> 
                <div class="ideal_weight">
                    <p id="label">Ideal weight:</p>
                    <p> <?php echo $commonUser->ideal_weight ?></p>
                </div> 
            <?php
                //
            } elseif(Person::isChef($user_id)){
                //
                $values= Chef::getChefFormation($user_id);
                ?>
                <div class="Course">
                    <p id="label">Course name:</p>
                    <p> <?php echo $values[1] ?></p>
                </div> 
                <div class="School">
                    <p id="label">School name:</p>
                    <p> <?php echo $values[2] ?></p>
                </div> <div class="Level">
                    <p id="label">Academic Level:</p>
                    <p> <?php echo $values[3] ?></p>
                </div> <div class="date">
                    <p id="label">Graduation date:</p>
                    <p> <?php echo $values[0] ?></p>
                </div> 
                
            <?php } elseif( Person::isNutritionist($user_id)){
                $values= Nutritionist::getNutriFormation($user_id);
                ?>
                <div class="Course">
                    <p id="label">Course name:</p>
                    <p> <?php echo $values[1] ?></p>
                </div> 
                <div class="School">
                    <p id="label">School name:</p>
                    <p> <?php echo $values[2] ?></p>
                </div> <div class="Level">
                    <p id="label">Academic Level:</p>
                    <p> <?php echo $values[3] ?></p>
                </div> <div class="date">
                    <p id="label">Graduation date:</p>
                    <p> <?php echo $values[0] ?></p>
                </div> 
                
            <?php 

            }


            ?>
        </div>
    </article>
<?php
}
?>