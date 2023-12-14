<?php

require_once(__DIR__ . '/../database/connection.db.php');

class Message
{
    public int $id;
    public string $sending_date;
    public string $content;
    public int $sender_id;
    public int $receiver_id;

    // Constructor
    public function __construct(int $id, string $sending_date, string $content, int $sender_id, int $receiver_id)
    {
        $this->id = $id;
        $this->sending_date = $sending_date;
        $this->content = $content;
        $this->sender_id = $sender_id;
        $this->receiver_id = $receiver_id;
    }

    // Add a new message to the database
    public static function addMessage(array $messageData): bool
    {
        $db = Database::getDatabase();

        $stmt = $db->prepare(
            'INSERT INTO Messages 
            (sending_date, content, sender_id, receiver_id)
            VALUES (?, ?, ?, ?)'
        );

        $values = [
            $messageData['sending_date'],
            $messageData['content'],
            intval($messageData['sender_id']),
            intval($messageData['receiver_id']),
        ];

        return $stmt->execute($values);
    }

    // Get messages between two persons
    public static function getMessagesBetweenPersons(int $personId1, int $personId2): array
    {
        $db = Database::getDatabase();

        $stmt = $db->prepare(
            'SELECT * FROM Messages 
            WHERE (sender_id = :personId1 AND receiver_id = :personId2)
            OR (sender_id = :personId2 AND receiver_id = :personId1)
            ORDER BY sending_date ASC'
        );

        $stmt->bindParam(':personId1', $personId1, PDO::PARAM_INT);
        $stmt->bindParam(':personId2', $personId2, PDO::PARAM_INT);
        $stmt->execute();

        $messageData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $messages = [];
        foreach ($messageData as $message) {
            $messages[] = new Message(
                $message['id'],
                $message['sending_date'],
                $message['content'],
                intval($message['sender_id']),
                intval($message['receiver_id'])
            );
        }

        return $messages;
    }public static function getUnreadMessagesForPerson(int $personId): array
    {
        $db = Database::getDatabase();
    
        $stmt = $db->prepare(
            'SELECT * FROM Messages 
            WHERE receiver_id = :personId AND is_read = 0
            ORDER BY sending_date ASC'
        );
    
        $stmt->bindParam(':personId', $personId, PDO::PARAM_INT);
        $stmt->execute();
    
        $messageData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $messages = [];
        foreach ($messageData as $message) {
            $messages[] = new Message(
                $message['id'],
                $message['sending_date'],
                $message['content'],
                intval($message['sender_id']),
                intval($message['receiver_id'])
            );
        }
    
        return $messages;
    }

    public static function getAllMessagesForPerson(int $personId): array
{
    $db = Database::getDatabase();

    $stmt = $db->prepare(
        'SELECT * FROM Messages 
        WHERE sender_id = :personId OR receiver_id = :personId
        ORDER BY sending_date ASC'
    );

    $stmt->bindParam(':personId', $personId, PDO::PARAM_INT);
    $stmt->execute();

    $messageData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $messages = [];
    foreach ($messageData as $message) {
        $messages[] = new Message(
            $message['id'],
            $message['sending_date'],
            $message['content'],
            intval($message['sender_id']),
            intval($message['receiver_id'])
        );
    }

    return $messages;
}

public static function markMessageAsRead(int $messageId): bool
{
    $db = Database::getDatabase();

    $stmt = $db->prepare('UPDATE Messages SET is_read = 1 WHERE id = :messageId');
    $stmt->bindParam(':messageId', $messageId, PDO::PARAM_INT);

    return $stmt->execute();
}



}
?>