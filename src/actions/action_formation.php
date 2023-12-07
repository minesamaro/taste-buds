<?php
include '../functions/enter_data_functions.php';

session_start(); 

$db = new PDO('sqlite:../database/database.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$user_id = $_SESSION['user_id'];
$occupation = $_SESSION['occupation'];


# turn inputs into variables
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id']) && isset($_SESSION['occupation'])) {     # block will only be executed when the form is submitted using the POST method -> for security
    
    $course_name = $_POST['course_name'];
    $school_name = $_POST['school_name'];

    addFormation($user_id, $course_name,$school_name, $occupation);
    header('Location: ../'); // To be changed to the profile
}

?>
