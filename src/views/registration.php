<?php
# Person Registration
function registration($msg){ ?>

<article class="content register-container">
    <h2>Create an account</h2>
    <?php if (isset($msg)) { ?>
        <p><?php echo $msg ?></p> 
    <?php } ?>

    <form class="register-form" action="../actions/action_registration.php" method="post" enctype="multipart/form-data">

        <div class="form-group">
            <label>First Name:
                <input type="text" id="first_name" name="first_name" required>        <!-- required since it must be filled out -->
            </label>
        </div>

        <div class="form-group">
            <label>Last Name:
                <input type="text" id="surname" name="surname" required>        <!-- required since it must be filled out -->
            </label>
        </div>

        <div class="form-group">
            <label>Username:
                <input type="text" id="username" name="username" required>        <!-- required since it must be filled out -->
            </label>
        </div>

        <div class="form-group">
            <label>Email:
                <input type="email" id="email" name="email" required>        <!-- required since it must be filled out -->
            </label>
        </div>

        <div class="form-group">
            <label>Password (min 8 characters):
                <input type="password" id="password" name="password" required>
            </label>
        </div>

        <div class="form-group">
            <label>Confirm Password:
                <input type="password" id="confirm_password" name="confirm_password" required>
            </label>
        </div>
        <!-- meter proteção passe - precisa de ser igual a anterior. tb deviamos meter um mínimo de caracteres-->

        <div class="form-date">     <!-- faco required ou sem ser required e depois a pessoa pode alterar a qualquer hora? -->
            <label>Birth Date:
                <input type="date" id="birth_date" name="birth_date" required>
            </label>
        </div>

        <div class="form-gender"> 
                <fieldset>      <!-- fazer com um tenha que ser preenchido; fazer aparecer na vertical: CSS -->
                    <legend>Gender:</legend>
                        <label>
                            <input class="radio-btn" type="radio" name="gender" value="female" required>Female <!-- ver como funcionam aqui os atributos -->
                        </label>
                        <label>
                            <input class="radio-btn" type="radio" name="gender" value="male" required>Male <!-- label deve aparecer depois para vir depois da bolinha -->
                        </label>
                        <label>
                            <input class="radio-btn" type="radio" name="gender" value="transgender" required>Transgender <!-- ver como funcionam aqui os atributos -->
                        </label>
                        <label>
                            <input class="radio-btn" type="radio" name="gender" value="non-binary" required>Non-binary/Non-conforming <!-- ver como funcionam aqui os atributos -->
                        </label>
                        <label>
                            <input class="radio-btn" type="radio" name="gender" value="not_respond" required>Prefer not to respond <!-- ver como funcionam aqui os atributos -->
                        </label>
                    
                        <!-- all the inputs share the same name so: -->
                        <!-- 1 - the required command will be fulfilled if at least one is selected  -->
                        <!-- 2 - only one can be selected (radio) -->
                 </fieldset>
        </div>

        <div class="form-occupation"> 
            <fieldset>      <!-- fazer com um tenha que ser preenchido; fazer aparecer na vertical: CSS -->
                <legend>What are you?</legend>

                    <label>
                        <input class="radio-btn" type="radio" name="occupation" value="chef" required>Chef <!-- ver como funcionam aqui os atributos -->
                    </label>
                    <label>
                        <input class="radio-btn" type="radio" name="occupation" value="nutritionist" required>Nutritionist <!-- label deve aparecer depois para vir depois da bolinha -->
                    </label>
                    <label>
                        <input class="radio-btn" type="radio" name="occupation" value="common_user" required>User <!-- ver como funcionam aqui os atributos -->
                    </label>


             </fieldset>
        </div>

        <!-- Image -->
        <div class="form-group">
        <label for="image">Upload Profile Photo:</label>
            <input type="file" name="profile_photo" id="profile_photo" accept="image/*">
        </div>

        <button type="submit">Register</button>
    </form>

</article>
<?php } 


// Common User Registration
function commonUserRegistration() {
    ?>
    <article class="content register-container">    
        <h2>Add your personal information:</h2>
        <form class="register-form" action="../actions/action_common_user.php" method="post">
    
            <div class="form-group">
                <label>Height (m):
                    <input type="n" id="height" name="height" placeholder="1.60" min="0" max="3" step="0.05" required>      
                </label>
            </div>
    
            <div class="form-group">
                <label>Current Weight (kg):
                    <input type="n" id="current_weight" name="current_weight" placeholder="60" min="0" max="600" step="1" required>        
                </label>
            </div>
    
            <div class="form-group">
                <label>Ideal Weight (kg):
                    <input type="n" id="ideal_weight" name="ideal_weight" placeholder="60" min="0" max="600" step="1" required>        <!-- required since it must be filled out -->
                </label>
            </div>
    
            <div class="form-group">
                <label>Primary Health Goal:
                   <select name="health_goal">
                    <option value="Overall Health">Overall Health</option>
                    <option value="Weight Loss">Weight Loss</option>
                    <option value="Boosted Immunity">Boosted Immunity</option>
                    <option value="Stress Reduction">Stress Reduction</option>
                    <option value="Improved Sleep">Improved Sleep</option>
                    <option value="Digestive Health">Digestive Health</option>
                    </select>
                </label>
            </div>
    
            <button type="submit">Save</button>
        </form>
    </div>
    </article>
    
    <?php }

# Formation - Chef or Nutritionist
function formation(){ ?>

<article class="content register-container">
<div class="register-container">        <!-- for css MUDAR DPS -->
    <h2>Add your formation:</h2>
    <form class="register-form" action="../actions/action_formation.php" method="post">

        <div class="form-group">
            <label>Course Name:
                <input type="text" id="course_name" name="course_name" required>        <!-- required since it must be filled out -->
            </label>
        </div>

        <div class="form-group">
            <label>School Name:
                <input type="text" id="school_name" name="school_name" required>        <!-- required since it must be filled out -->
            </label>
        </div>

        <div class="form-group">
        <label>Academical Level:
               <select name="academic_level">
                <option value="Associate Degree">Associate Degree</option>
                <option value="Bachelors Degree">Bachelor's Degree</option>
                <option value="Masters Degree">Master's Degree</option>
                <option value="Doctoral Degree">Doctoral Degree</option>
                </select>
            </label>
        </div>

        <div class="form-date">
            <label>Graduation Date:
                <input type="date" id="graduation_date" name="graduation_date" required>
            </label>
        </div>

        <button type="submit">Add Formation</button>
    </form>
</div>
</article>

<?php }
?>