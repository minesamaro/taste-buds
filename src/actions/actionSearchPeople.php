<?php
require_once(__DIR__ . '/../database/person.class.php');

session_start();


function getIntersection($array1, $array2) {
    $intersection = array_filter($array1, function($obj1) use ($array2) {
        return array_filter($array2, function($obj2) use ($obj1) {
            return $obj1->id == $obj2->id;
        });
    });

    return array_values($intersection);
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $searchQuery = $_GET['search'] ?? '';
    $_SESSION['isPeopleSearch'] = $searchQuery ?? false;

    // Perform the search using the $searchQuery
    $people = Person::searchPeople($searchQuery);

    if (isset($_SESSION["isPeopleFiltered"]) && isset($_SESSION["people"])) {
        $filteredPeople = $_SESSION["people"];
        $intersection = getIntersection($people, $filteredPeople);                
        $_SESSION["people"] = $intersection;
    } else {
        $_SESSION["people"] = $people;
    }

    // Redirect to the peopleIndex page after the search
    header("Location: ../pages/peopleIndex.php?searchy=" . urlencode($searchQuery));
    exit();
} else {
    echo "Form not submitted.";
}
?>