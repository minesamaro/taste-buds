<?php # destruir a sessão
  session_start(); 
  session_destroy();
  header('Location: registration.php');
?>

