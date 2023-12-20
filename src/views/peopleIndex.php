<?php 
require_once(__DIR__ . '/../database/person.class.php');
require_once(__DIR__ . '/../database/chef.class.php');
require_once(__DIR__ . '/../database/commonUser.class.php');
require_once(__DIR__ . '/../database/nutritionist.class.php');

function peopleIndex($people, $page) { 
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
                            echo "User";
                        }
                        ?>
                    </h5>
                </div>

                <div class="card-body" id="card-body_people">
                    <h5>Username: <?= $person->username ?></h5>
                </div>

                <div class="card-footer" id="card-footer_people">
                    <?php if(isset($_SESSION['user_id'])){ ?>
                        <forms class="card-button">
                            <a href="../pages/messages.php?personId=<?php echo $personId; ?>"><button class="button-small"> Send Message</button></a> 
                        </forms>
                <?php } ?>
            </div>
            </div>

            

        </div>
        
<?php } 
if (!isset($_SESSION['isPeopleSearch']) && !isset($_SESSION['isPeopleFiltered'])) {
?>
    <div class="page-number">
        <?php if ($page > 1) { ?>
            <a href="../pages/peopleIndex.php?page=<?= $page - 1; ?>"> &#x2190; </a>
        <?php } ?>
        <p> <?= $page; ?> / <?= Person::getNumberOfPages(); ?></p>
        <?php if ($page < Person::getNumberOfPages()) { ?>
            <a href="../pages/peopleIndex.php?page=<?= $page + 1; ?>"> &#x2192; </a>
        <?php } ?>
    </div>
<?php } ?>
</article>
</div>

<?php } }?>