<?php
// Add new plan to database with user id
require_once(__DIR__ . '/../database/person.class.php');


session_start();
$user_id=$_SESSION['user_id'];
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {     # block will only be executed when the form is submitted using the POST method -> for security
    // retrieve person data
    $person = Person::getPersonById($user_id);
    $password = $_POST["new_pass"];
    $checkPassword=$_POST["check_pass"];
    //check if the password has at least 8 characters
    if (strlen($password) < 8) {
        $_SESSION['msg'] = 'Password must have at least 8 characters.';
        header('Location: ../pages/changePassword.php');
        die();
    }
    //check if the passwords match
    elseif ($password !== $checkPassword){
        $_SESSION['msg'] = "Passwords don't match!";
        header('Location: ../pages/changePassword.php');
        die();
    }
    else{
        $password=hash('sha256', $password);
    }
   
    //change the password in the database
    Person::changePassword($user_id,$password);
    
header("Location: ../pages/profile.php");
}
?>