<?php
require_once('../views/header.php');
require_once('../views/footer.php');
require_once('../views/login.php');

// Check if user is  not logged in, other wise redirect to 404 page
if (isset($_SESSION['user_id'])) {
    header("Location: ../");
} else {
    head("Log In");
    login();
    footer();
}
?>