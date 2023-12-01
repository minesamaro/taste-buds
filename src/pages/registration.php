<?php
session_start();
if (isset($_SESSION['msg'])){
$msg = $_SESSION['msg'];
unset($_SESSION['msg']);
}
?>

<!DOCTYPE html>

<html lang="en">
<head>
    <title>Register</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">      <!-- for device adaptation -->
    <!-- Link your CSS file here -->
    <link rel="stylesheet" href="#">
</head>
<body>

<div class="register-container">        <!-- for css -->
    <h2>Create an account</h2>
    <?php if (isset($msg)) { ?>
        <p><?php echo $msg ?></p> 
    <?php } ?>

    <form class="register-form" action="action_registration.php" method="post">

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
                            <input type="radio" name="gender" value="female" required>Female <!-- ver como funcionam aqui os atributos -->
                        </label>
                        <label>
                            <input type="radio" name="gender" value="male" required>Male <!-- label deve aparecer depois para vir depois da bolinha -->
                        </label>
                        <label>
                            <input type="radio" name="gender" value="transgender" required>Transgender <!-- ver como funcionam aqui os atributos -->
                        </label>
                        <label>
                            <input type="radio" name="gender" value="non-binary" required>Non-binary/Non-conforming <!-- ver como funcionam aqui os atributos -->
                        </label>
                        <label>
                            <input type="radio" name="gender" value="not_respond" required>Prefer not to respond <!-- ver como funcionam aqui os atributos -->
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
                        <input type="radio" name="occupation" value="chef" required>Chef <!-- ver como funcionam aqui os atributos -->
                    </label>
                    <label>
                        <input type="radio" name="occupation" value="nutritionist" required>Nutritionist <!-- label deve aparecer depois para vir depois da bolinha -->
                    </label>
                    <label>
                        <input type="radio" name="occupation" value="common_user" required>User <!-- ver como funcionam aqui os atributos -->
                    </label>


                   <!-- php: if (chef or nutritionist) ver como fazer --> 
                   <!-- php: if (common user) ver como fazer --> 

             </fieldset>
    </div>

        <button type="submit">Register</button>
    </form>
</div>

</body>
</html>