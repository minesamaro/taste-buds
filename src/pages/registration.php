<?php
require_once('../views/header.php');
require_once('../views/footer.php');
require_once('../views/registration.php');

// Check if a user is not logged in
if (isset($_SESSION['user_id']) && !isset($_SESSION['reg_page'])){
    header("Location: ../pages/404.php");
} else {
    if (isset($_SESSION['msg'])){
    $msg = $_SESSION['msg'];
    unset($_SESSION['msg']);
    }
    else {
        $msg = null;
    }

    head("Log In");
    if (!isset($_SESSION['reg_page'])){
        registration($msg);
    }
    elseif ($_SESSION['reg_page'] == "common_user"){
        commonUserRegistration();
    }
    elseif ($_SESSION['reg_page'] == "formation"){
        formation();
    }

    

    

    $_SESSION['reg_page'] = null;
    footer();
}
?>

