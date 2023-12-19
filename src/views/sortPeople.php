<?php
require_once(__DIR__ . '/../database/person.class.php');
require_once(__DIR__ . '/../database/cooking.technique.class.php');

function sortPeople()
{
    // Check if there are selected categories, techniques, and preferences
    $selectedOccupations = isset($_SESSION['selectedOccupations']) ? $_SESSION['selectedOccupations'] : [];?>
<div item="sort">

<!-- Clear filters for people -->
<form action="../actions/actionClearPeopleFilters.php" method="POST">
    <button type="submit">Clear Filters</button>
</form>

<!-- Sort people based on selected occupations -->
<form action="../actions/actionFilterPeopleIndex.php" method="POST">
    <button type="submit">Filter</button>

    <div class="filter-block order">
        <div class="filter-occupation">
            <h4>Occupation</h4>
                    <?php 
                    $occupations = ['Chef', 'Nutritionist', 'Common User'];
                    foreach ($occupations as $ocp) { ?>
                    <div class="category">
                        <div class="checkbox-wrapper-6">
                            <!-- Use name="occupations[]" to capture multiple selected values as an array -->
                            <input class="tgl tgl-light" id="cat-<?php echo $ocp ?>" type="checkbox" name="occupations[]" value="<?php echo $ocp ?>" <?php echo in_array($ocp, $selectedOccupations) ? 'checked' : ''; ?>>
                            <label class="tgl-btn" for="cat-<?php echo $ocp ?>"></label>
                        </div>
                        <p><?php echo $ocp ?></p>
                    </div>
                    <?php } ?>
         </div>

</form>
    </div>

</div>


<?php 
unset($_SESSION["selectedOccupations"]);
}


?>