<?php 
require_once(__DIR__ . '/../database/person.class.php');

function Profile(){
    ?>
    <article class="content">
        <h2>Profile</h2>
        </div>
        <section class="card">
                <div class="card-header">
                    <h4>
                        <a href="#"><?php echo $person->username?></a>
                    </h4>
                    <h6>
                       <?php echo $person->first_name?>,
                       <?php echo $person->surname?>
                    </h6>
                </div>
                <h5>
                    <?php echo $person->email ?>
                    <?php echo $person->birth_date ?>
                    <?php echo $person->gender ?>
                </h5>
                
            </section>
    </article>
<?php
}
?>