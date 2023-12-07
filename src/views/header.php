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
    <title><?= $title ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="icon" href="../img/favicon.icon">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
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
                <li><a href="../pages/recipeIndex.php">Recipes</a></li>
                <li><a href="#">Menu</a></li>
                <li><a href="#">About</a></li>
            </ul>
        </div>

        <div class="user-specific header__nav">
            <ul>
                <?php
                    // Check if the username is set in the session
                    if (isset($_SESSION['username'])) {
                        echo '<li><a href="#">Profile</a></li>';
                        var_dump($_SESSION['user_id']);
                        var_dump(Person::isChef($_SESSION['user_id']));
                        var_dump(Person::isNutritionist($_SESSION['user_id']));
                        var_dump(Person::isCommonUser($_SESSION['user_id']));
                    }
                    if (isset($_SESSION['user_id'])) {
                        if (Person::isChef($_SESSION['user_id'])) {
                            echo '<li><a href="../pages/addRecipe.php">Create Recipe</a></li>';
                        } elseif (Person::isNutritionist($_SESSION['user_id'])) {
                            echo '<li><a href="../pages/addPlan.php">Add Plan </a></li>';
                        } elseif (Person::isCommonUser($_SESSION['user_id'])) {
                            echo '<li><a href="../pages/recipeIndex.php">My Plans </a></li>';
                        }
                    }
                ?> 
            </ul>
        </div>


        <div id="login-signup">
        <?php
            // Check if the username is set in the session
            if (isset($_SESSION['user_id'])) {
                echo '<a href="../actions/action_logout.php">Log out</a>';
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