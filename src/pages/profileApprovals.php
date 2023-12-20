<?php
  require_once(__DIR__ . '/../views/footer.php');
  require_once(__DIR__ . '/../views/header.php');
  require_once(__DIR__ . '/../views/profileApprovals.php');

  head("Approvals"); 
  profileApprovals();
  footer();
?>