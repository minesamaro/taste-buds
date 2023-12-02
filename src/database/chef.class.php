<?php
    require_once(__DIR__ . '/../database/database.class.php');

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

       # acho que n precisamos de nenhum get chef pq o unico atributo é chef_id e vai ser o msm que é da person


        
    }

?>