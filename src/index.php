<?php 
// Create a basic layout that calls the footer function
// Path: src/index.php
require_once('pages/footer.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Taste Buds</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>
<body>
    <header>
        <div class="header">
            <div class="header__logo">
                <p>Taste Buds</p>
            </div>
            <div class="header__nav">
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Menu</a></li>
                    <li><a href="#">About</a></li>
                </ul>
            </div>
        </div>
    </header>
    <main>
        <div class="main">
            <div class="main__title">
                <h1>Delicious</h1>
                <h1>Food</h1>
            </div>
            <div class="main__subtitle">
                <p>Delicious food delivered to you</p>
            </div>
            <div class="main__button">
                <button>Order Now</button>
            </div>
        </div>
    </main>
    <?php footer(); ?>
</body>
</html>

