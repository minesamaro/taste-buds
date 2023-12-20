<?php
// Include necessary classes and start session if not already started
require_once(__DIR__ . '/../views/header.php');
require_once(__DIR__ . '/../views/footer.php');
require_once(__DIR__ . '/../database/message.class.php');
require_once(__DIR__ . '/../database/person.class.php');


// Retrieve user ID from the session
$userId = $_SESSION['user_id'] ?? 1;

// Get a list of people with whom the logged-in person has messages
$peopleWithMessages = Message::getPeopleWithMessages($userId);

// Get the ID of the person whose conversation to display (default to the most recent)
$selectedPersonId = $_GET['personId'] ?? null;

if ($selectedPersonId) {
    $selectedPerson = Person::getPersonById($selectedPersonId);
    $selectedPerson_FullName = $selectedPerson->first_name . " " . $selectedPerson->surname;

    // Get the messages for the selected person
    $conversation= Message::getMessagesBetweenPeople($userId, $selectedPersonId);

    // Mark all messages with this person as read
    if($conversation) { 
        if(Message::checkLastMsgWithPersonWasReceived($userId, $selectedPersonId)) 
        {
            Message::markMessagesWithPersonAsRead($userId, $selectedPersonId);
        }
    }
    

    head("Messages: " . $selectedPerson->first_name . " " . $selectedPerson->surname);
} else {
    $conversation = null;
    head("Messages");
};

?>


<body>
<main>
<div class="messages">

    <!-- Left side: List of people with whom the logged-in person has messages -->
    <div id="messages-peopleWithMessages">
        <h2 id="messages-main_title">Messages</h2>
        <div id="messages-people_cards">
            <?php   
                if(!empty($peopleWithMessages)) {
                    foreach ($peopleWithMessages as $person) { 
                        $profile_pic = ltrim($person->profile_photo, '/');                        $lastMessage = Message::getLastMessageFromPerson($userId, $person->id);
                        $isLastMessageReceived = Message::checkLastMsgWithPersonWasReceived($userId, $person->id);
                        $isRead = $lastMessage && $isLastMessageReceived ? $lastMessage->is_read : true;
                        $class = !$isRead ? 'message-bold' : ''; ?>
                    
                
                        <div class="card-small" id="card-small_messages">
                            <div class="card-header" id="card-header_messages">
                                <img class="message-profile_photo" src="<?php echo $profile_pic; ?>" alt="<?php echo $person->username; ?>'s profile photo">
                                <a class="<?php echo $class; ?>" id="message-person_name_card" href="?personId=<?php echo $person->id; ?>">
                                    <?php echo $person->first_name . " " .  $person->surname; ?>
                                </a>
                            </div>
                        </div>
                    
            <?php   } 
                } else { ?>
                    <p>No messages yet.</p>
            <?php } ?>
                </div>
    </div>

    <!-- Right side: Display messages for the selected person -->
    <div id="messages-conversation">
        <?php if ($selectedPersonId) { ?>
            <div id="messages-conversation-header">
                <a href="profile.php?user_id=<?php echo $selectedPersonId; ?>"><h3 id="messages-conversation_person_name"> <?php echo $selectedPerson_FullName; ?></h3> </a>
            </div>
       
            <?php if ($conversation) { ?>
                <div class="card" id="messages-conversation_content">
                    <?php 
                    $last_date = 0;
                    $last_message_sender = 0;
                    
                     ?>
                    <?php foreach ($conversation as $message) { ?>
                        <?php
                            $formattedDate = date("d-m-Y", strtotime($message->sending_date));
                            
                            if ($formattedDate != $last_date) {
                                $show_date = true;
                            }
                            else {
                                $show_date = false;
                            }

                            if ($message->sender_id != $last_message_sender) {
                                $show_sender = true;
                            } else {
                                $show_sender = false;
                            }

                            if($userId == $message->sender_id) {
                                $class = 'message-sent';
                            } else {
                                $class = 'message-received';
                            }

                            $formattedHour = date("H:i", strtotime($message->sending_date));
                            $sender = Person::getPersonById($message->sender_id);
                            $sender_FullName = $sender->first_name . " " . $sender->surname;
                        ?>
                        <div>
                        
                            <div class="<?php echo $class;?>">
                            
                            <?php if ($show_sender && $last_message_sender) { ?>
                                <small><?php echo $sender_FullName; ?></small>
                                <?php } $last_message_sender = $message->sender_id;?>
                            <br>
                                <div class="message-content_individual_message">
                                <?php echo $message->content; ?>
                                </div>
                            <br>
                            <small class="message-hours"><?php echo $formattedHour; ?></small>
                            </div>

                            <div id="message-date">
                            <?php if ($show_date && $last_date!=0) { ?>
                                <small><?php echo $last_date; ?></small>
                                <br>
                            <?php } $last_date=$formattedDate; ?>
                            </div>

                            
                        </div>
                        
                    <?php } ?>
                        <div id="message-date">
                            <small><?php echo $last_date; ?></small>
                            <br>             
                        </div>

                    <div style="clear: both;"></div> <!-- Clear the float -->
                </div>
            <?php } else { ?>
                <p>No messages with this person yet. Be the first to send a message.</p>
            <?php } ?>

            <!-- Form to write and send a message to the selected person -->
            <form id="message-write_message" action="../actions/action_sendMessage.php" method="post">

                <input type="hidden" name="receiver_id" value="<?php echo $selectedPersonId; ?>">
                <label for="message_content">Write a message:</label>
                <textarea name="message_content" id="message-write_textarea" rows="3" required></textarea>
                <br>
                <button type="submit">Send</button>

            </form> 

        <?php } elseif (!empty($peopleWithMessages)) { ?>
            <p>Select a person to display the conversation.</p> <!-- PODEMOS MUDAR ISTO DEPOIS --> 
        <?php } ?>

    </div>

</div>

</main>
</body>
</html>

<?php
footer();
?>
