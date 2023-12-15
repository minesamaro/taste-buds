<?php
// Include necessary classes and start session if not already started
require_once(__DIR__ . '/../database/message.class.php');

session_start();

// Retrieve user ID from the session
$userId = $_SESSION['user_id'] ?? null;

// Initiate Message
$message = new Message();

// Get a list of people with whom the logged-in person has messages
$peopleWithMessages = $message->getPeopleWithMessages($userId);

// Get the ID of the person whose conversation to display (default to the most recent)
$selectedPersonId = $_GET['person_id'] ?? null;

// Get the messages for the selected person
$selectedPersonMessages = $selectedPersonId
    ? $messageDB->getMessagesBetweenPeople($userId, $selectedPersonId)
    : $messageDB->getMostRecentMessages($userId);

// Display HTML
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <!-- Add your styles and scripts here -->
</head>
<body>

<div style="display: flex;">

    <!-- Left side: List of people with whom the logged-in person has messages -->
    <div style="flex: 1;">
        <h2>People with Messages</h2>
        <ul>
            <?php foreach ($peopleWithMessages as $person) { ?>
                <li>
                    <a href="?person_id=<?php echo $person->getId(); ?>">
                        <?php echo $person->getFullName(); ?>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </div>

    <!-- Right side: Display messages for the selected person -->
    <div style="flex: 2;">
        <h2>Conversation</h2>
        <?php if ($selectedPersonMessages) { ?>
            <ul>
                <?php foreach ($selectedPersonMessages as $message) { ?>
                    <li>
                        <?php echo $message->getContent(); ?>
                        <br>
                        <small>Sent on <?php echo $message->getSendingDate(); ?> by <?php echo $message->getSenderFullName(); ?></small>
                    </li>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <p>No messages with this person.</p>
        <?php } ?>

        <!-- Form to write and send a message -->
        <form action="send_message.php" method="post">
            <input type="hidden" name="receiver_id" value="<?php echo $selectedPersonId; ?>">
            <label for="message_content">Write a message:</label>
            <textarea name="message_content" id="message_content" rows="3" required></textarea>
            <br>
            <button type="submit">Send Message</button>
        </form>
    </div>

</div>

</body>
</html>
