<?php
require_once('../views/header.php');
require_once('../views/footer.php');
require_once('../views/registration.php');
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
    common_user($msg);
}
elseif ($_SESSION['reg_page'] == "formation"){
    formation($msg);
}


footer();


?>

