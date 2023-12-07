<?php
function login($msg){ ?>

<article class="content login-container">
<?php if (!isset($_SESSION['username'])) { ?>
    <h2>Log in to your account</h2>
    <?php if (isset($msg)) { ?>
        <p><?php echo $msg ?></p> 
    <?php } ?>
    
    <form class="login-form" action="../actions/action_login.php" method="post">
        <div class="form-group">
            <label>Username:
                <input type="text" id="username" name="username" required>        <!-- required since it must be filled out -->
            </label>
        </div>

        <div class="form-group">
            <label>Password:
                <input type="password" id="password" name="password" required>
            </label>
        </div>

        <button type="submit">Log In</button>

        <a href="registration.php">Register</a> <!-- ADAPTAR -->
    </form>
    <?php } else { ?>
        <h2>You are already signed as </h2><?php echo " ".$_SESSION['username'];?>
        <form id="logout" action="../actions/action_logout.php"> <!-- fazemos um mini form que é só o botão para log out, vamos ter que criar o ficheiro action_logout.php -->
          <button>Logout</button>
        </form>
        <form id="homepage-redirect" action="../actions/action_homepage.php"> <!-- fazemos um mini form que é só o botão para log out, vamos ter que criar o ficheiro action_logout.php -->
          <button>Go back to homepage</button> <!-- ACABAR ISTO -->
        </form>
    <?php } ?>


</article>
<?php } ?>