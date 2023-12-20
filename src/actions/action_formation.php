<?php
session_start(); 
require_once(__DIR__ . '/../database/person.class.php');
require_once(__DIR__ . '/../database/chef.class.php');
require_once(__DIR__ . '/../database/nutritionist.class.php');
require_once(__DIR__ . '/../database/connection.db.php');

$db=Database::getDatabase();

$user_id = $_SESSION['user_id'];
$occupation = $_SESSION['occupation'];

# turn inputs into variables
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id']) && isset($_SESSION['occupation'])) {     # block will only be executed when the form is submitted using the POST method -> for security
    
    $course_name = $_POST['course_name'];
    $school_name = $_POST['school_name'];
    $graduation_date = $_POST['graduation_date'];
    $academic_level = $_POST['academic_level'];



    switch ($occupation) {
        case 'chef':
            Chef::addChef($user_id, $course_name, $school_name, $graduation_date, $academic_level);
            break;
        case 'nutritionist':
            Nutritionist::addNutritionist($user_id, $course_name, $school_name, $graduation_date, $academic_level);
            break;
    }

        header('Location: ../index.php');
   

   

    
}

?>
