<?php 
require_once(__DIR__ . '/../database/person.class.php');
require_once(__DIR__ . '/../database/chef.class.php');
require_once(__DIR__ . '/../database/commonUser.class.php');
require_once(__DIR__ . '/../database/nutritionist.class.php');

function peopleIndex($people) { 
    ?>
<div item="recipeIndex">
<article class="content">
<h2>Find Someone</h2>
<?php

if (count($people) == 0) { ?>
    <h4>No people found</h4>
<?php }
else{
foreach ($people as $person) { 
    $personId = $person->id;
    ?>
        <div class="card card-with-img">
           <!-- <img class="card-img" src="--> <?#= $person->profile_photo ?><!--" alt="--><?#= $person->username . "profile photo" ?><!--" /> ATUALIZAR DEPOIS -->
            <div>
                <div class="card-header">
                    <!-- <a href="../pages/profile.php?personId?<?php #$personId ?>"> ATUALIZAR--><h4><?= $person->first_name . " " . $person->surname; ?></h4><!--</a>-->
                    <h5><?php 
                        if(Person::isChef($personId)) {
                            echo "Chef";
                        }
                        elseif(Person::isNutritionist($personId)) {
                            echo "Nutritionist";
                        }
                        elseif(Person::isCommonUser($personId)) {
                            echo "Common User";
                        }
                        ?>
                    </h5>
                </div>

                <div class="card-body">
                    <h5>Username: <?= $person->username ?></h5>
                </div>

                <forms class="card-button">
                    <div class="card-footer">
                        <a href="../pages/profile.php?personId?<?php echo $personId; ?>">View Profile</a>
                    </div>
                </forms>

                <forms class="card-button">
                    <div class="card-footer">
                        <a href="../pages/messages.php?personId?<?php echo $personId; ?>">Send Message</a>  
                    </div>
                </forms>

            </div>
        </div>
<?php } ?>
</article>
</div>

<?php } }?>