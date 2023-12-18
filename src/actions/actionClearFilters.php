<?php
session_start();

unset($_SESSION['selectedCategories']);
unset($_SESSION['selectedTechniques']);
unset($_SESSION['selectedPreferences']);
$_SESSION['orderBy'] = 'recent';
unset($_SESSION['recipes']);


// Redirect back to the main page or wherever you need
header("Location: ../pages/recipeIndex.php");
exit();
?>
