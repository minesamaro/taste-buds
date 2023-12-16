<?php
// Add new plan to database with user id
require_once(__DIR__ . '/../database/person.class.php');
require_once(__DIR__ . '/../database/commonUser.class.php');
require_once(__DIR__ . '/../database/chef.class.php');
require_once(__DIR__ . '/../database/nutritionist.class.php');

$user_id=$_SESSION['user_id'];

// retrieve person data
$firstName = $_POST["firstName"];
$surname = $_POST["surname"];

//Check user type and get for each
if (Person::isCommonUser($user_id)){
    $height = $_POST["height"];
    $curr_weight = $_POST["curr_weight"];


}elseif(Person::isChef($user_id)){
    $course = $_POST["course"];
    $school = $_POST["school"];
    Person::changeInfo($course,$school);


}elseif(Person::isNutritionist($user_id)){
    $course = $_POST["course"];
    $school = $_POST["school"];

}



header("Location: ../pages/addPlanRecipe.php?planId=$planId");

?>