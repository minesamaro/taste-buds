<?php
  require_once(__DIR__ . '/../views/footer.php');
  require_once(__DIR__ . '/../views/header.php');

 // Create Page not found page
 function pageNotFound(){
    ?>
    <div item="pageNotFound">
    <article class="content error">
        <img src="../img/utils/404.png" alt="Page Not Found" height="500em">
        <h2>Page Not Found</h2>
        <h4>Sorry, the page you are looking for does not exist or you don't have permission to access it.</h4>
        <h6>Please go back to main page.</h6>
    </article>
    </div>
    <?php
}
  head("Add Recipe");
  pageNotFound();
  footer();
?>