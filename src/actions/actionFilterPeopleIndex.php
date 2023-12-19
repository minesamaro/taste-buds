<?php
require_once(__DIR__ . '/../database/chef.class.php');
require_once(__DIR__ . '/../database/nutritionist.class.php');
require_once(__DIR__ . '/../database/commonUser.class.php');

session_start();

function getIntersection($array1, $array2) {
    $intersection = array_filter($array1, function($obj1) use ($array2) {
        return array_filter($array2, function($obj2) use ($obj1) {
            return $obj1->id == $obj2->id;
        });
    });

    return array_values($intersection);
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Handle occupation
    $selectedOccupations = isset($_POST['occupations']) ? $_POST['occupations'] : [];

    if($selectedOccupations) {
        $_SESSION['isPeopleFiltered'] = true;
    }

    $people = Person::getPeopleByOccupations($selectedOccupations);

    if(isset($_SESSION['isPeopleSearch']) && isset($_SESSION["people"])) {
        $searchedPeople = $_SESSION["people"];
        $intersection = getIntersection($people, $searchedPeople);                
        $_SESSION["people"] = $intersection;
    } else {
        $_SESSION["people"] = $people;
    }

    // Set the selected categories, techniques, and preferences in the session
    $_SESSION['selectedOccupations'] = $selectedOccupations;

    
    //var_dump($_SESSION['selectedPreferences']);
    header("Location: ../pages/peopleIndex.php");
    exit();

    
} else {
    echo "Form not submitted.";
}
?>