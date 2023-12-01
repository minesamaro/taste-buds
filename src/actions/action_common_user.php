<?php
include 'enter_data_functions.php';

session_start(); 

$db = new PDO('sqlite:database.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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

    addCommonUser($user_id, $height, $current_weight, $ideal_weight);
    addHealthGoal($user_id,$health_goal);

echo "Successful Registration!";
}
?>


<form id="homepage-redirect" action="action_homepage.php"> 
  <button>Go back to homepage</button> 
</form>

