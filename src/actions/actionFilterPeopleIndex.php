<?php
require_once(__DIR__ . '/../database/chef.class.php');
require_once(__DIR__ . '/../database/nutritionist.class.php');
require_once(__DIR__ . '/../database/commonUser.class.php');

session_start();

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Handle occupation
    $selectedOccupations = isset($_POST['occupations']) ? $_POST['occupations'] : [];

    $people = Person::getPeopleByOccupations($selectedOccupations);
    $_SESSION['people'] = $people;

    // Set the selected categories, techniques, and preferences in the session
    $_SESSION['selectedOccupations'] = $selectedOccupations;

    
    //var_dump($_SESSION['selectedPreferences']);
    header("Location: ../pages/peopleIndex.php");
    exit();

    
} else {
    echo "Form not submitted.";
}
?>