<?php
session_start();

require_once('../views/header.php');
require_once('../views/footer.php');
require_once('../views/login.php');

head("Log In");
login();
footer();
?>








