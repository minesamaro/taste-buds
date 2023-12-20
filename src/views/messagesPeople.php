<?php
require_once(__DIR__ . '/../database/message.class.php');

function showPeopleWithMessages($peopleWithMessages, $userId) { ?>
<body>
<main>
<div class="messages">

<div id="messages-peopleWithMessages">
        <h2 id="messages-main_title">Messages</h2>
        <div id="messages-people_cards">
            <?php   
                if(!empty($peopleWithMessages)) {
                    foreach ($peopleWithMessages as $person) { 
                        $profile_pic = ltrim($person->profile_photo, '/');                        
                        $lastMessage = Message::getLastMessageFromPerson($userId, $person->id);
                        $isLastMessageReceived = Message::checkLastMsgWithPersonWasReceived($userId, $person->id);
                        $isRead = $lastMessage && $isLastMessageReceived ? $lastMessage->is_read : true;
                        $class = !$isRead ? 'message-bold' : ''; ?>
                    
                
                        <div class="card-small" id="card-small_messages">
                            <div class="card-header" id="card-header_messages">
                                <img class="message-profile_photo" src="<?php echo $profile_pic; ?>" alt="<?php echo $person->username; ?>'s profile photo">
                                <a class="<?php echo $class; ?>" id="message-person_name_card" href="?personId=<?php echo $person->id; ?>">
                                    <?php 
                                    if ($class) { echo "> "; }
                                    echo $person->first_name . " " .  $person->surname; ?>
                                </a>
                            </div>
                        </div>
                    
            <?php   } 
                } else { ?>
                    <p>No messages yet.</p>
            <?php } ?>
                </div>
    </div>

<?php } ?>