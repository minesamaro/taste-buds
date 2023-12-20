<?php
// Include necessary classes and start session if not already started
require_once(__DIR__ . '/../views/header.php');
require_once(__DIR__ . '/../views/footer.php');
require_once(__DIR__ . '/../views/messagesPeople.php');
require_once(__DIR__ . '/../views/messagesDisplayConversation.php');
require_once(__DIR__ . '/../database/message.class.php');
require_once(__DIR__ . '/../database/person.class.php');


$userId = $_SESSION['user_id']; // Retrieve user ID from the session
$peopleWithMessages = Message::getPeopleWithMessages($userId); // Get a list of people with whom the logged-in person has messages
$selectedPersonId = $_GET['personId'] ?? null; // Get the ID of the person whose conversation to display (if any)
$selectedPerson_FullName = null; // Initialize the variable that will hold the name of the selected person

// If a person was selected, get their name
if ($selectedPersonId) {
    $selectedPerson = Person::getPersonById($selectedPersonId);
    $selectedPerson_FullName = $selectedPerson->first_name . " " . $selectedPerson->surname;

    // Get the messages for the selected person
    $conversation= Message::getMessagesBetweenPeople($userId, $selectedPersonId);

    // Mark all messages with this person as read
    if($conversation) 
    { 
        if(Message::checkLastMsgWithPersonWasReceived($userId, $selectedPersonId)) 
        {
            Message::markMessagesWithPersonAsRead($userId, $selectedPersonId);
        }
    }
    

    head("Messages: " . $selectedPerson_FullName);
} else {
    $conversation = null;
    head("Messages");
};

showPeopleWithMessages($peopleWithMessages, $userId); 
displayConversation($peopleWithMessages, $userId, $selectedPersonId, $selectedPerson_FullName, $conversation);
footer();
?>
