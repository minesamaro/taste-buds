<?php 
require_once(__DIR__ . '/../database/person.class.php');
require_once(__DIR__ . '/../database/commonUser.class.php');
require_once(__DIR__ . '/../database/chef.class.php');
require_once(__DIR__ . '/../database/nutritionist.class.php');

function changeProfile(){ 
    $user_id=$_SESSION['user_id'];
    $personUser = Person::getPersonById($user_id);
    ?>
    <article class="center-content" id="profile">
        <div class="profile-photo">
        <img class="profile-profile_photo card-img" src="<?php echo $personUser->profile_photo; ?>"  alt="Profle Picture" width=100px height=100px>
       
        </div>
        <div class="card profile-changepass">
            <a href="changePassword.php">Change Password</a>
        </div>
        <?php if(!Person::isChef($user_id)) {?>
        <div class="card profile-myplans">
            <a href="changePassword.php">My plans</a>
        </div>
        <?php }else { ?>
            <div class="card profile-myrecipes">
            <a href="changePassword.php">My Recipes</a>
        </div>
        <?php } ?>
        <div class="card profile-update">
            <a href="changeProfile.php">Update Profile</a>
        </div>
        <form  class="card profile-info" method="POST" action="../actions/actionChangeProfile.php" id="changeProfile" enctype="multipart/form-data">
            

            
                <h2>My Profile</h2>
                <div class="username">
                   <p id="label">Username:</p>
                   <p> <?php echo $personUser->username ?></p>
                </div>
                <div class="name">
                    <label for="name" id="label">First name:</label>
                    <input type="text" placeholder="<?php echo $personUser->first_name?>" id="name" name="firstName" >
                </div>
                <div class="surname">
                    <label for="surname" id="label">Surname:</label>
                    <input type="text" placeholder="<?php echo $personUser->surname?>" id="surname" name="surname" >
                
                </div>

                <?php
                // if user is common_user show info, if user is chef or nutri, show formation
                if (Person::isCommonUser($user_id)){
                    $commonUser = CommonUser::getCommonUserById($user_id);?>
                    <div class="height">
                        <label for="height" id="label">Height:</label>
                        <input type="number" placeholder="<?php echo $commonUser->height?>" id="height" name="height" step="any" >
                    </div> 
                    <div class="curr_weight">
                        <label for="curr_weight" id="label">Current weight:</label>
                        <input type="number" placeholder="<?php echo $commonUser->current_weight?>"id="curr_weight" name="curr_weight" step="any" >
                    </div> 
                    <div class="ideal_weight">
                        <label for="ideal_weight" id="label">Ideal Weight:</label>
                        <input type="number" placeholder="<?php echo $commonUser->ideal_weight?>" id="ideal_weight" name="ideal_weight" step="any" >
                    </div> 
                    <div class="form-group">
                        <label for="image">Upload Profile Photo:</label>
                            <input type="file" name="profile_photo" id="profile_photo" accept="image/*">
                        </div>
                    <button type="submit">Change Profile</button>
                <?php
                    //
                } elseif(Person::isChef($user_id)){
                    //
                    $values= Chef::getChefFormation($user_id);
                    ?>
                    <div class="course">
                        <label for="course_name" id="label">Course name:</label>
                        <input type="text" placeholder="<?php echo $values[1] ?> " id="course_name" name="course_name" >
                    </div> 
                    <div class="school">
                        <label for="school_name" id="label">School name:</label>
                        <input type="text" placeholder="<?php echo $values[2] ?> " id="school_name" name="school_name" >
                    </div> <div class="Level">
                        <label for="academic_level" id="label">Academic level:</label>
                        <input type="text" placeholder="<?php echo $values[3] ?> " id="academic_level" name="academic_level" >
                    </div> <div class="date">
                        <label for="graduation_date" id="label">Graduation date:</label>
                        <input type="date" placeholder="<?php echo $values[0] ?> " id="graduation_date" name="graduation_date" >
                    </div> 
                    <div class="form-group">
                        <label for="image">Upload Profile Photo:</label>
                            <input type="file" name="profile_photo" id="profile_photo" accept="image/*">
                        </div>
                    <button type="submit">Change Profile</button>
                    
                <?php } elseif( Person::isNutritionist($user_id)){
                    $values= Nutritionist::getNutriFormation($user_id);
                    ?>
                    <div class="course">
                        <label for="course_name" id="label">Course name:</label>
                        <input type="text" placeholder="<?php echo $values[1] ?> " id="course_name" name="course_name" >
                    </div> 
                    <div class="school_name">
                        <label for="school_name" id="label">School name:</label>
                        <input type="text" placeholder="<?php echo $values[2] ?> " id="school_name" name="school_name" >
                    </div> <div class="Level">
                        <label for="academic_level" id="label">Academic level:</label>
                        <input type="text" placeholder="<?php echo $values[3] ?> " id="academic_level" name="academic_level" >
                    </div> <div class="date">
                        <label for="graduation_date" id="label">Graduation date:</label>
                        <input type="date" placeholder="<?php echo $values[0] ?> " id="graduation_date" name="graduation_date" >
                    </div> 
                    <div class="form-group">
                        <label for="image">Upload Profile Photo:</label>
                            <input type="file" name="profile_photo" id="profile_photo" accept="image/*">
                        </div>
                    <button type="submit">Submit changes</button>
                    
                <?php 

                }


                ?>
            
        </form>
    </article>
<?php
}
?>