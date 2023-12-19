<?php
require_once(__DIR__ . '/../database/person.class.php');

function searchPeople()
{
    $searchQuery = isset($_GET['search']) ? $_GET['search'] : '';
?>

<div class="search" id="search_people">

<form action="../actions/actionSearchPeople.php" method="GET">
    <label for="search">Search People:</label>
    <input type="text" name="search" id="search" value="<?php echo htmlspecialchars($searchQuery); ?>">
    <button type="submit">Search</button>
</form>

</div>


<?php } ?>