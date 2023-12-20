<?php
  require_once(__DIR__ . '/../views/footer.php');
  require_once(__DIR__ . '/../views/header.php');
  require_once(__DIR__ . '/../views/profileRatings.php');


if (!isset($_SESSION['user_id'])) {
  header("Location: ../pages/404.php");

} else {
  head("Ratings"); 
  profileRatings();
  footer();
}
?>