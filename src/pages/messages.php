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
$selectedPersonId = $_GET['person_id'] ?? null;
var_dump($selectedPersonId);

if ($selectedPersonId) {
    $selectedPerson = Person::getPersonById($selectedPersonId);
    $selectedPerson_FullName = $selectedPerson->first_name . " " . $selectedPerson->surname;

    // Get the messages for the selected person
    $conversation= Message::getMessagesBetweenPeople($userId, $selectedPersonId);

    // Mark all messages with this person as read
    Message::markMessagesWithPersonAsRead($userId, $selectedPersonId);

    head("Messages: " . $selectedPerson->first_name . " " . $selectedPerson->surname);
} else {
    $conversation = null;
    head("Messages");
};

?>



<div class="messages">

    <!-- Left side: List of people with whom the logged-in person has messages -->
    <div class="messages-peopleWithMessages">
        <h2>Messages</h2>
        <ul>
            <?php   
                if(!empty($peopleWithMessages)) {
                    foreach ($peopleWithMessages as $person) { ?>
                        <li>
                            <a href="?person_id=<?php echo $person->id; ?>">
                                <?php echo $person->first_name . " " .  $person->surname; ?>
                            </a>
                        </li>
            <?php   } 
                } else { ?>
                    <p>No messages yet.</p>
            <?php } ?>
        </ul>
    </div>

    <!-- Right side: Display messages for the selected person -->
    <div class="messages-conversation">
        <?php if ($selectedPersonId) { ?>
            <a href="profile.php?user_id=<?php echo $selectedPersonId; ?>"><?php echo $selectedPerson_FullName; ?> </a>
       
            <?php if ($conversation) { ?>
                <ul>
                    <?php foreach ($conversation as $message) { ?>
                        <?php 
                            $formattedDate = date("d-m-Y", strtotime($message->sending_date)); 
                            $formattedHour = date("H:i", strtotime($message->sending_date));
                            $sender = Person::getPersonById($message->sender_id);
                            $sender_FullName = $sender->first_name . " " . $sender->surname;
                        ?>
                        <li>
                            <?php echo $message->content; ?>
                            <br>
                            <small><?php echo $formattedDate . ", " . $formattedHour; ?> - by <?php echo $sender_FullName; ?></small>
                        </li>
                    <?php } ?>
                </ul>
            <?php } else { ?>
                <p>No messages with this person yet. Be the first to send a message.</p>
            <?php } ?>

            <!-- Form to write and send a message to the selected person -->
            <form action="../actions/action_sendMessage.php" method="post">

                <input type="hidden" name="receiver_id" value="<?php echo $selectedPersonId; ?>">
                <label for="message_content">Write a message:</label>
                <textarea name="message_content" id="message_content" rows="3" required></textarea>
                <br>
                <button type="submit">Send</button>

            </form> 

        <?php } elseif (!empty($peopleWithMessages)) { ?>
            <p>Select a person to display the conversation.</p> <!-- PODEMOS MUDAR ISTO DEPOIS --> 
        <?php } ?>

    </div>

</div>

</body>
</html>
