<?php
require_once(__DIR__ . '/../database/person.class.php');

function searchRecipes()
{
    $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
?>

<div class="search" id="search_recipes">

<form action="../actions/actionSearchRecipes.php" method="GET">
    <label for="search">Search Recipes:</label>
    <input type="text" name="search" id="search" autocomplete="off" value="<?php echo htmlspecialchars($searchQuery); ?>">
    <button type="submit">Search</button>
</form>

</div>


<?php } ?>