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
$selectedPersonId = $_GET['person_id'] ?? null; # USAR ISTO PARA PASSAR AO CLICAR NO BOTAO DE ENVIAR MSG, E PARA MOSTRAR A CONVERSA COM A PESSOA QUE CLICOU

if ($selectedPersonId) {
    $selectedPerson = Person::getPersonById($selectedPersonId);
    $selectedperson_FullName = $selectedPerson->first_name . " " . $selectedPerson->surname;

    // Get the messages for the selected person
    $conversation= Message::getMessagesBetweenPeople($userId, $selectedPersonId);

    // Mark all messages with this person as read
    Message::markMessagesWithPersonAsRead($userId, $selectedPersonId);
} else {
    $conversation = null;
};

// Display HTML
head("Messages: " . $selectedPerson->first_name . " " . $selectedPerson->surname);
?>



<div style="display: flex;">

    <!-- Left side: List of people with whom the logged-in person has messages -->
    <div class="messages-peopleWithMessages">
        <h2>Messages</h2>
        <ul>
            <?php foreach ($peopleWithMessages as $person) { ?>
                <li>
                    <a href="?person_id=<?php echo $person->id; ?>">
                        <?php echo $person->first_name . $person->surname; ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>

    <!-- Right side: Display messages for the selected person -->
    <div class="messages-conversation">
        <?php if ($selectedPersonId) { ?>
            <a href="?person_id=<?php echo $selectedPerson_FullName; ?>"><?php echo $selectedPerson_FullName; ?></a>
       
            <?php if ($conversation) { ?>
                <ul>
                    <?php foreach ($conversation as $message) { ?>
                        <li>
                            <?php echo $message->content; ?>
                            <br>
                            <small>Sent on <?php echo $message->sending_date; ?> by <?php echo $selectedPerson_FullName; ?></small>
                        </li>
                    <?php } ?>
                </ul>
            <?php } else { ?>
                <p>No messages with this person yet. Be the first to send a message.</p>
            <?php } ?>
        <?php } else { ?>
            <p>Select a person to display the conversation.</p> <!-- PODEMOS MUDAR ISTO DEPOIS --> 
        <?php } ?>

        <!-- Form to write and send a message -->
        <?php if ($selectedPersonId) { ?>
            
            <form action="send_message.php" method="post">
                <input type="hidden" name="receiver_id" value="<?php echo $selectedPersonId; ?>">

                <label for="message-content">Write a message:</label>
                <textarea name="message-content" id="message-content" rows="3" required></textarea>
                <br>
                <button type="submit">Send</button>
            </form>

        <?php } ?>
    </div>

</div>

</body>
</html>
