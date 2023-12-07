<?php
    require_once(__DIR__ . '/../database/connection.db.php');

    class Chef {
        private $id;

        /* Constructor */
        public function __construct($id) {
            $this->id = $id;          
        }
        public function getId() {
            return $this->id;
        }

        static function addChef($user_id) : Chef {
            $db = Database::getDatabase();
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            try {
                $db->beginTransaction();
                $stmt = $db->prepare('INSERT INTO Chef (chef_id) VALUES (?)');        
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