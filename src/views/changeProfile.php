<?php 
require_once(__DIR__ . '/../database/person.class.php');
require_once(__DIR__ . '/../database/commonUser.class.php');
require_once(__DIR__ . '/../database/chef.class.php');
require_once(__DIR__ . '/../database/nutritionist.class.php');

function changeProfile(){ 
    $user_id =2;
    $personUser = Person::getPersonById($user_id);
    ?>
    <article class="content" id="profile">
        <div class="profile-photo">
            <img src="profile.png" alt="Profle Picture" width=100px height=100px>
            <a href="#changePassword">Change Password</a>
        </div>
        <div class="profile-info">
            <h2>My Profile</h2>
            <div class="username">
                <p>Username:</p>
                <p> <?php echo $personUser->username ?></p>
            </div>
            <div class="name">
                <label for="name">First name:</label>
                <input type="text" placeholder="<?php echo $personUser->first_name?>" id="name" name="name" required>
            </div>
            <div class="surname">
                <label for="surname">Surname:</label>
                <input type="text" placeholder="<?php echo $personUser->surname?>" id="surname" name="surname" required >
                
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
                    <label for="height">Height:</label>
                    <input type="number" placeholder="<?php echo $commonUser->height?>" id="height" name="height" required>
                </div> 
                <div class="curr_weight">
                    <label for="curr_weight">Current weight:</label>
                    <input type="number" placeholder="<?php echo $commonUser->current_weight?>"id="curr_weight" name="curr_weight" required>
                </div> 
                <div class="ideal_weight">
                    <label for="ideal_weight">Ideal Weight:</label>
                    <input type="number" placeholder="<?php echo $commonUser->ideal_weight?>" id="ideal_weight" name="ideal_weight" required>
                </div> 
                <button type="submit">Change Profile</button>
            <?php
                //
            } elseif(Person::isChef($user_id)){
                //
                $chef = Chef::getCommonUserById($user_id)
                $values= Chef::getChefFormation($user_id);
                ?>
                <div class="course">
                    <label for="course">Course name:</label>
                    <input type="text" placeholder="<?php echo $commonUser->height?>"id="course" name="course" required>
                </div> 
                <div class="school">
                    <label for="school">School name:</label>
                    <input type="text" id="school" name="school" required>
                </div> <div class="Level">
                    <label for="academic_lvl">Academic level:</label>
                    <input type="text" id="academic_lvl" name="academic_lvl" required>
                </div> <div class="date">
                    <label for="date">Graduation date:</label>
                    <input type="date" id="date" name="date" required>
                </div> 
                <button type="submit">Change Profile</button>
                
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
                <button type="submit">Change Profile</button>
                
            <?php 

            }


            ?>
        </div>
    </article>
<?php
}
?>