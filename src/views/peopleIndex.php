<?php 
require_once(__DIR__ . '/../database/person.class.php');
require_once(__DIR__ . '/../database/chef.class.php');
require_once(__DIR__ . '/../database/commonUser.class.php');
require_once(__DIR__ . '/../database/nutritionist.class.php');

function peopleIndex($people) { 
    ?>
<div id="peopleIndex">
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
        <div class="card card-with-img" id = "car-with-img_people">
            <img class="card-img" id="card-img_people" src="<?php echo $person->profile_photo; ?>" alt="<?php echo $person->username; ?>'s profile photo">
            <div>
                <div class="card-header">
                    <a href="../pages/profile.php?person_id=<?php echo $personId; ?>"><h4 id="card-people_name"><?= $person->first_name . " " . $person->surname; ?></h4></a>
                    <h5 id="card-people_occupation"><?php 
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

                <div class="card-body" id="card-body_people">
                    <h5>Username: <?= $person->username ?></h5>
                </div>

                <div class="card-footer" id="card-footer_people">
                <forms class="card-button">
                    <h5><a href="../pages/profile.php?person_id=<?php echo $personId; ?>">View Profile</a></h5>
                </forms>
                <forms class="card-button">
                    <h5><a href="../pages/messages.php?personId=<?php echo $personId; ?>">Send Message</a></h5>  
                </forms>
            </div>
            </div>

            

        </div>
        
<?php } ?>
</article>
</div>

<?php } }?>