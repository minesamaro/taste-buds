<?php
session_start(); 

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/message.class.php');

$db=Database::getDatabase();

$user_id = $_SESSION['user_id'];

# turn inputs into variables
if ($_SERVER["REQUEST_METHOD"] == "POST") {     # block will only be executed when the form is submitted using the POST method -> for security
    
    $content = nl2br($_POST['message_content']);
    $receiver_id = $_POST['receiver_id'];

    Message::addMessage($content, $user_id, $receiver_id);

    header('Location: ../pages/messages.php' . '?personId=' . $receiver_id);
//ter cuidado aqui que não sei se isto vai depois para o user que está log in ou receiver id


}

?>