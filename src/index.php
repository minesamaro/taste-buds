<?php 
// Create a basic layout that calls the footer function
// Path: src/index.php
require_once(__DIR__ . '/views/footer.php');
require_once(__DIR__ . '/views/header.php');

head("Home");
 ?>
<article class="content">
        <div class="main">
            <div class="main__img"> 
                <img src="https://images.pexels.com/photos/1640777/pexels-photo-1640777.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="Recipes and Plans">
            </div>
            <div class="main__title">
                <h1>Your All Food Website</h1>
            </div>
            <div class="main__subtitle">
                <p>Delicious food and health at your fingertips.</p>
            </div>
            <div class="main__button">
                <a href="../pages/recipeIndex.php"><button>Start Browsing</button></a>
            </div>
        </div>
</article>
<?php footer(); ?>
</html>