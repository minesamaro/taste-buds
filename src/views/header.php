<?php
    session_start();

function head($title)
{
    require_once(__DIR__ . '/../database/person.class.php');
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Taste Buds is a website where you can find recipes and meal plans for your diet.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="../css/responsive.css">
    <link rel="icon" href="../img/utils/favicon.icon">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>
    <header>
        <div class="header__logo">
            <a href="../" id="title">Taste Buds</a>
        </div>
        <div class="header__nav">
            <ul>
                <li><a href="../pages/peopleIndex.php">People</a></li>
                <li><a href="../pages/recipeIndex.php">Recipes</a></li>
                <li><a href="../pages/aboutUs.php">About us</a></li>
            </ul>
        </div>

        <div class="user-specific header__nav">
            <ul>
                <?php
                    // Check if the username is set in the session
                    if (isset($_SESSION['user_id'])) {
                        echo '<li><a href="../pages/messages.php">Messages</a></li>';
                    }
                    if (isset($_SESSION['user_id'])) {
                        echo '<li><a href="../pages/profile.php">Profile</a></li>';
                    }
                    if (isset($_SESSION['user_id'])) {
                        if (Person::isChef($_SESSION['user_id'])) {
                            echo '<li><a href="../pages/addRecipe.php">Create Recipe</a></li>';
                        } elseif (Person::isNutritionist($_SESSION['user_id'])) {
                            echo '<li><a href="../pages/addPlan.php">Add Plan </a></li>';
                            echo '<li><a href="../pages/profilePlans.php">My Plans </a></li>';
                        } elseif (Person::isCommonUser($_SESSION['user_id'])) {
                            echo '<li><a href="../pages/profilePlans.php">My Plans </a></li>';
                        }
                    }
                ?> 
            </ul>
        </div>


        <div id="login-signup">
        <?php
            // Check if the username is set in the session
            if (isset($_SESSION['user_id'])) {
                echo '<a href="../actions/actionLogout.php">Log out</a>';
            } else {
                echo '<a href="../pages/login.php">Log in</a>';
                echo '<a href="../pages/registration.php">Sign up</a>';
            }
            ?>        
        </div>
    </header>
<?php
}

?>