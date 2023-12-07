<?php
if (isset($_SESSION['msg'])){
$msg = $_SESSION['msg'];
unset($_SESSION['msg']);
}
else {
    $msg = null;
}

require_once('../views/header.php');
require_once('../views/footer.php');
require_once('../views/login.php');

head("Log In");
login($msg);
footer();
?>








