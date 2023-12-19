<?php
session_start();

unset($_SESSION['selectedOccupations']);
unset($_SESSION['people']);
unset($_SESSION['isPeopleFiltered']);
unset($_SESSION['isPeopleSearch']);


// Redirect back to the main page or wherever you need
header("Location: ../pages/peopleIndex.php");
exit();
?>