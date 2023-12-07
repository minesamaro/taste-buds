<?php
    require_once(__DIR__ . '/../database/connection.db.php');

    class Nutritionist {
        private $id;

        /* Constructor */
        public function __construct($id) {
            $this->id = $id;          
        }
        public function getId() {
            return $this->id;
        }

        static function addNutritionist($user_id) : Nutritionist {
            $db = Database::getDatabase();
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            try {
                $db->beginTransaction();
                $stmt = $db->prepare('INSERT INTO Nutritionist (id) VALUES (?)');        
                $stmt->execute(array($user_id));
            
                $db->commit();
            }
        
            catch (Exception $e) {
                $db->rollBack();
                echo "Error: " . $e->getMessage();
            }
        } 

    }

?>