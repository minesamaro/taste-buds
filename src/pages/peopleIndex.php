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


// Check if there is a page number in the URL
if (isset($_GET["page"])) {
    $page = intval($_GET["page"]);
    // If the page number is less than 1, set it to 1
    if ($page < 1) {
        $page = 1;
    }
    // If the page number is greater than the last page, set it to the last page
    if ($page > Person::getNumberOfPages()) {
        $page = Person::getNumberOfPages();
    }
} else {
    $page = 1;
}

// If there is a cookie with the users, use the recipes that match the filters
if (isset($_SESSION["people"])) {
    $people = $_SESSION["people"];
} else {
    $people = Person::getAllPersons($page);
}


head("All People");
?>
<main class="indexBundle">
<?php 
filters(); 
sortPeople();
searchPeople();
peopleIndex($people, $page);
?>
</main>
<?php
footer();
?>