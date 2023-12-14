<?php 
require_once(__DIR__ . '/../database/person.class.php');
require_once(__DIR__ . '/../database/commonUser.class.php');
require_once(__DIR__ . '/../database/chef.class.php');
require_once(__DIR__ . '/../database/nutritionist.class.php');

function Profile(){ 
    $user_id =1;
    $personUser = Person::getPersonById($user_id);
    ?>
    <article class="content" id="profile">
        <div class="profile-photo">
            <img src="profile.png" alt="Profle Picture" width=100px height=100px>
        </div>
        <div class="profile-changepass">
            <a href="changePassword.php">Change Password</a>
        </div>

        <div class="profile-info">
            <h2>My Profile</h2>
            <div class="username">
                <p>Username:</p>
                <p> <?php echo $personUser->username ?></p>
            </div>
            <div class="name">
                <p>Name:</p>
                <p><?php echo $personUser->first_name ?></p>
            </div>
            <div class="surname">
                <p>Surnname:</p>
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
                    <p>Height:</p>
                    <p> <?php echo $commonUser->height ?></p>
                </div> 
                <div class="curr_weight">
                    <p>Current Weight:</p>
                    <p> <?php echo $commonUser->current_weight ?></p>
                </div> 
                <div class="ideal_weight">
                    <p>Ideal weight:</p>
                    <p> <?php echo $commonUser->ideal_weight ?></p>
                </div> 
            <?php
                //
            } elseif(Person::isChef($user_id)){
                //
                $values= Chef::getChefFormation($user_id);
                ?>
                <div class="Course">
                    <p>Course:</p>
                    <p> <?php echo $values[1] ?></p>
                </div> 
                <div class="School">
                    <p>School:</p>
                    <p> <?php echo $values[2] ?></p>
                </div> <div class="Level">
                    <p>Academic Level:</p>
                    <p> <?php echo $values[3] ?></p>
                </div> <div class="date">
                    <p>Graduation Date:</p>
                    <p> <?php echo $values[0] ?></p>
                </div> 
                
            <?php } elseif( Person::isNutritionist($user_id)){
                $values= Nutritionist::getNutriFormation($user_id);
                ?>
                <div class="Course">
                    <p>Course:</p>
                    <p> <?php echo $values[1] ?></p>
                </div> 
                <div class="School">
                    <p>School:</p>
                    <p> <?php echo $values[2] ?></p>
                </div> <div class="Level">
                    <p>Academic Level:</p>
                    <p> <?php echo $values[3] ?></p>
                </div> <div class="date">
                    <p>Graduation Date:</p>
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