<?php
session_start();

unset($_SESSION['selectedOccupations']);
unset($_SESSION['people']);


// Redirect back to the main page or wherever you need
header("Location: ../pages/peopleIndex.php");
exit();
?>