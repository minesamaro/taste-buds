<?php
require_once(__DIR__ . '/../database/recipe.class.php');
function filters(){
?>
<div id="filters">
    <?php
    // If there is a cookie with the selected categories, use the selected categories
    if (isset($_SESSION["selectedCategories"]) && !empty($_SESSION["selectedCategories"])) {
        $categories = $_SESSION["selectedCategories"];
        echo  "<h4> &nbsp; Categories>  &nbsp;  </h4> <p>";
        echo is_array($categories) ? implode(', ', $categories) : $categories; 
        echo "</p>";
    } 
    if (isset($_SESSION['selectedTechniques']) && !empty($_SESSION['selectedTechniques'])) {
        $techniques = $_SESSION['selectedTechniques'];
        echo  "<h4> &nbsp; > &nbsp; Techniques > &nbsp;  </h4> <p>";
        echo is_array($techniques) ? implode(', ', $techniques) : $techniques;
        echo "</p>";
    } 
    if (isset($_SESSION['selectedPreferences']) && !empty($_SESSION['selectedPreferences'])) {
        $preferences = $_SESSION['selectedPreferences'];
        echo  "<h4> &nbsp; > &nbsp; Preferences &nbsp; > &nbsp;  </h4> <p>";
        echo is_array($preferences) ? implode(', ', $preferences) : $preferences;
        echo "</p>";
    }
    if (isset($_SESSION['isPeopleFiltered']) && !empty($_SESSION['selectedOccupations'])) {
        $occupations = $_SESSION['selectedOccupations'];
        echo  "<h4> &nbsp; > &nbsp; Occupation &nbsp; > &nbsp;   </h4> <p>";
        echo is_array($occupations) ? implode(', ', $occupations) : $occupations;
        echo "</p>";
    }
    if (isset($_SESSION['isPeopleSearch'])) {
        echo  "<h4> &nbsp; > &nbsp; Search> &nbsp; </h4> <p>";
        echo $_SESSION['isPeopleSearch']; 
        echo "</p>";
    }
    if (isset($_SESSION['isRecipeSearch'])) {
        echo  "<h4> &nbsp; > &nbsp; Search> &nbsp; </h4> <p>";
        echo $_SESSION['isRecipeSearch']; 
        echo "</p>";
    }
    ?>
</div>
<?php } ?>