<?php 
require_once(__DIR__ . '/../database/person.class.php');


function Profile(){ 
    $user_id =6;
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
                <p>Name:</p>
                <p><?php echo $personUser->first_name ?></p>
            </div>
            <div class="surname">
                <p>Surnname:</p>
                <p><?php echo $personUser->surname ?></p>
            </div>

            <?php
            var_dump(Person::isCommonUser($user_id));
            var_dump($user_id);
            // if user is common_user show info, if user is chef or nutri, show formation
            if (Person::isCommonUser($user_id)){
                $commonUser = CommonUser::getCommonUserById($user_id);?>
                <div class="height">
                    <p>Height:</p>
                    <p> <?php echo $commonUser->height ?></p>
                </div> <?php
                //
            } elseif(Person::isChef($user_id) || Person::isNutritionist($user_id)){
                //
            }


            ?>
        </div>
    </article>
<?php
}
?>