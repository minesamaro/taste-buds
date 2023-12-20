<?php
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/commonUser.class.php');

session_start(); 

$db = Database::getDatabase();

# Ensure $_SESSION['user_id'] is available
if (!isset($_SESSION['user_id'])) {
    // Handle the case where user_id or occupation is not set, maybe redirect to the registration page
    echo "Session data not set. Please go back to the registration page.";
    exit();
}

$user_id = $_SESSION['user_id'];

# turn inputs into variables
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {     # block will only be executed when the form is submitted using the POST method -> for security
    
    $height = $_POST['height'];
    $current_weight = $_POST['current_weight'];
    $ideal_weight = $_POST['ideal_weight'];
    $health_goal = $_POST['health_goal'];

    CommonUser::addCommonUser($user_id, $height, $current_weight, $ideal_weight, $health_goal);


    header('Location: ../index.php');
}
?>

