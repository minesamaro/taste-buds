<?php

require_once(__DIR__ . '/../database/connection.db.php');

class Message
{
    public int $id;
    public string $sending_date;
    public string $content;
    public bool $is_read;
    public int $sender_id;
    public int $receiver_id;

    // Constructor
    public function __construct(int $id, string $sending_date, string $content, bool $is_read, int $sender_id, int $receiver_id)
    {
        $this->id = $id;
        $this->sending_date = $sending_date;
        $this->content = $content;
        $this->is_read = $is_read;
        $this->sender_id = $sender_id;
        $this->receiver_id = $receiver_id;
    }

    // Add a new message to the database - returns 1 if successful, 0 otherwise
    public static function addMessage(array $messageData): bool
    {
        $db = Database::getDatabase();

        $stmt = $db->prepare(
            'INSERT INTO Messages 
            (sending_date, content, sender_id, receiver_id)
            VALUES :sending_date, :content, :sender_id, :receiver_id'
        );
        // is_read is set to 0 by default


        $values = [
            $messageData['sending_date'],
            $messageData['content'],
            intval($messageData['sender_id']),
            intval($messageData['receiver_id']),
        ];

        $stmt->bindParam(':sending_date', $values[0], PDO::PARAM_STR);
        $stmt->bindParam(':content', $values[1], PDO::PARAM_STR);
        $stmt->bindParam(':sender_id', $values[2], PDO::PARAM_INT);
        $stmt->bindParam(':receiver_id', $values[3], PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Get messages between two persons - returns an array of Message objects if successful, empty array otherwise
    public static function getMessagesBetweenPersons(int $userId, int $personId2): array
    {
        $db = Database::getDatabase();

        $stmt = $db->prepare(
            'SELECT * FROM Messages 
            WHERE (sender_id = :userId AND receiver_id = :personId2)
            OR (sender_id = :personId2 AND receiver_id = :userId)
            ORDER BY sending_date ASC'
        );

        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':personId2', $personId2, PDO::PARAM_INT);
        $stmt->execute();

        $messageData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $messages = array();
        foreach ($messageData as $msg) {
            array_push ($messages, new Message(
                intval($msg['id']),
                $msg['sending_date'],
                $msg['content'],
                $msg['is_read'],
                intval($msg['sender_id']),
                intval($msg['receiver_id'])
            ));
        }

        return $messages;
    }
    
    // Get the most recent (unread) messages for a person - returns an array of Message objects if successful, empty array otherwise
    public static function getUnreadMessagesForPerson(int $userId): array
    {
        $db = Database::getDatabase();
    
        $stmt = $db->prepare(
            'SELECT * FROM Messages 
            WHERE receiver_id = :userId AND is_read = 0
            ORDER BY sending_date ASC'
        );
    
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
    
        $messageData = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $messages = array();
        foreach ($messageData as $msg) {
            array_push($messages, new Message(
                intval($msg['id']),
                $msg['sending_date'],
                $msg['content'],
                $msg['is_read'],
                intval($msg['sender_id']),
                intval($msg['receiver_id'])
            ));
        }
    
        return $messages;
    }

    public static function getAllMessagesForPerson(int $userId): array
    {
        $db = Database::getDatabase();

        $stmt = $db->prepare(
            'SELECT * FROM Messages 
            WHERE sender_id = :userId OR receiver_id = :userId
            ORDER BY sending_date ASC'
        );

        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $messageData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $messages = array();
        foreach ($messageData as $msg) {
            array_push ($messages, new Message(
                intval($msg['id']),
                $msg['sending_date'],
                $msg['content'],
                $msg['is_read'],
                intval($msg['sender_id']),
                intval($msg['receiver_id'])
            ));
        }

        return $messages;
    }

    // Mark a message as read - returns 1 if successful, 0 otherwise
    public static function markMessageAsRead(int $messageId): bool
    {
        $db = Database::getDatabase();

        $stmt = $db->prepare(
            'UPDATE Messages 
            SET is_read = 1 
            WHERE id = :messageId');

        $stmt->bindParam(':messageId', $messageId, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Get a list of people with whom the specified user has messages
     *
     * @param int $userId
     * @return array
     */
    public static function getPeopleWithMessages(int $userId): array
    {
        $db = Database::getDatabase();
        $stmt = $db->prepare(
            'SELECT DISTINCT P.id, P.first_name, P.surname
            FROM Person AS P
            JOIN Messages AS M1 ON P.id = M1.sender_id
            WHERE M1.receiver_id = :userId   
            
            UNION
            
            SELECT DISTINCT P.id, P.first_name, P.surname
            FROM Person AS P
            JOIN Messages AS M2 ON P.id = M2.receiver_id
            WHERE M2.sender_id = :userId'  
        );
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $peopleWithMessages = $stmt->execute();

        $people = array();
        foreach ($peopleWithMessages as $p) {
            array_push ($people, 
                $p['id'], 
                $p['first_name'], 
                $p['surname']
            );
        }

        return $people;
    }
}
?>