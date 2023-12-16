<?php 
require_once(__DIR__ . '/../database/person.class.php');


function changePassword(){ 
    $user_id =2;
    $personUser = Person::getPersonById($user_id);
    ?>
    <article class="content" id="change_password">
        <div class=new_pass>
            <label for="new_pass">New password:</label>
            <input type="text" id="new_pass" name="new_pass" required>
        </div>
        <div class=check_pass>
            <label for="check_pass">Confirm new password:</label>
            <input type="text" id="check_pass" name="check_pass" required>
        </div>
        <button type="submit">Change Password</button>
    </article>

<?php
}
?>