<?php 
require_once(__DIR__ . '/../database/person.class.php');


function changePassword($msg){ 
    $user_id =2;
    $personUser = Person::getPersonById($user_id);
    ?>
    
    <article class="center-content" id="change_password">
        <form  class="card change_password" method="POST" action="../actions/actionChangePass.php" id="changePass">
            <?php if (isset($msg)) { ?>
                <p><?php echo $msg ?></p> 
            <?php } ?>

            <div class="new_pass">
                <label for="new_pass">New password:</label>
                <input type="text" id="new_pass" name="new_pass" required>
            </div>
            <div class="check_pass">
                <label for="check_pass">Confirm new password:</label>
                <input type="text" id="check_pass" name="check_pass" required>
            </div>
            <div>
                <button  type="submit">Change Password</button>
            </div>
            
    
        </form>
    </article>

<?php
}
?>