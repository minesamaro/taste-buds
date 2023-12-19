<?php
require_once(__DIR__ . '/../database/recipe.class.php');
require_once(__DIR__ . '/../database/person.class.php');
require_once(__DIR__ . '/../database/chef.class.php');
require_once(__DIR__ . '/../database/commonUser.class.php');
require_once(__DIR__ . '/../database/nutritionist.class.php');
require_once(__DIR__ . '/../views/header.php');
require_once(__DIR__ . '/../views/footer.php');
require_once(__DIR__ . '/../views/peopleIndex.php');
require_once(__DIR__ . '/../views/sortPeople.php');
require_once(__DIR__ . '/../views/searchPeople.php');
require_once(__DIR__ . '/../views/filters.php');



// If there is a cookie with the users, use the recipes that match the filters
if (isset($_SESSION["people"])) {
    $people = $_SESSION["people"];
} else {
    $people = Person::getAllPersons();
}

head("All People");
?>
<main class="indexBundle">
<?php 
filters(); 
sortPeople();
searchPeople();
peopleIndex($people);
?>
</main>
<?php
footer();
?>