<?php 
require_once(__DIR__ . '/../database/commonUser.class.php');

function planForm(){
    ?>
    <div class="addPlan">
        <div class="addPlan__title">
            <h1>Add New Plan</h1>
        </div>
        <div class="addPlan__form">
            <form >
                <div class="addPlan__form__username">
                    <label for="username">User Name</label>
                    <!-- TODO get username from db and dropdown -->
                    <select name="username">
                        <?php 
                        //TODO: get list of users from db
                        $users = CommonUser::getUsers();
                        var_dump($users);
                        foreach ($users as $user) { ?>
                             <option value="<?php echo $user->id ?>">
                        </option> 
                        <?php } ?>
                    </select>
                </div>
            
            <button formaction="actionAddPlan" formmethod="post" type="submit"></button>
            </form>
        </div>
    </div>
<?php
}
?>