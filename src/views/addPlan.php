<?php 
require_once(__DIR__ . '/../database/commonUser.class.php');

function planForm(){
    ?>
    <article class="content">
        <h2>Add New Plan</h2>
        </div>
        <div class="addPlan__form">
            <form method="GET" action="../actions/actionAddPlan.php">
                <div class="addPlan__form__username">
                    <label for="username">User Name</label>
                    <!-- TODO get username from db and dropdown -->
                    <select name="id" class="userSelect">
                        <?php 
                        //TODO: get list of users from db
                        $users = CommonUser::getUsers();
                        foreach ($users as $user) { ?>
                             <option value="<?php echo $user->id ?>"><?php echo $user->first_name." ".$user->surname ?></option>
                        </option> 
                        <?php } ?>
                    </select>
                </div>
            <button id="addRecipeBt" type="submit">Add Recipe</button>
            </form>
        </div>
    </article>
<?php
}
?>