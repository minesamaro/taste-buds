<?php
    require_once(__DIR__ . '/../database/connection.db.php');

    class Chef {
        public $id;
        /* public $course_name;
        public $school_name;
        public $graduation_date;
        public $academic_level; */


        /* Constructor */
        public function __construct($id) {
            $this->id = $id;
            /* $this->course_name;
            $this->$school_name;
            $this->$graduation_date;
            $this->$academic_level; */

        }
        public function getId() {
            return $this->id;
        }

        static function addChef($user_id, $course_name, $school_name, $graduation_date, $academic_level) {
            $db = Database::getDatabase();
            
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

            try {
                $db->beginTransaction();
                $stmt = $db->prepare('INSERT INTO Formation (user_id,course_name, school_name, academic_level, graduation_date) VALUES (?,?,?,?)');        
                $stmt->execute(array($user_id,$course_name, $school_name, $academic_level, $graduation_date));
                $db->commit();
            }
        
            catch (Exception $e) {
                $db->rollBack();
                echo "Error: " . $e->getMessage();
            }

            try {
                $db->beginTransaction();
                $stmt = $db->prepare('INSERT INTO ChefFormation (chef_id, course_name, school_name) VALUES (?,?,?)');        
                $stmt->execute(array($user_id, $course_name, $school_name));
                $db->commit();
            }
        
            catch (Exception $e) {
                $db->rollBack();
                echo "Error: " . $e->getMessage();
            }
        } 

        public static function getChefFormation($user_id)
        {
            $db = Database::getDatabase();
            $query = 'SELECT course_name, school_name, academic_level , graduation_date
            FROM Formation 
            WHERE user_id = ?';

            $stmt = $db->prepare($query);
    
            //$stmt->execute([$user_id]);
            $stmt->execute([$user_id]);


            while ($nutriform = $stmt->fetch()) {
                $values = [$nutriform['graduation_date'],
                $nutriform['course_name'],
                $nutriform['school_name'],
                $nutriform['academic_level']];
            }
            return $values;
          
        }
        
        
         /* Get array of Chefs 
        *
        * @return array of Chefs
        */
        public static function getChefs() {
            $chefList = array();
            $db = Database::getDatabase();
            $req = $db->query('SELECT Person.*, Chef.* 
            FROM Person
            JOIN Chef ON Person.id = Chef.chef_id');

            // Include the Person attributes
            foreach($req->fetchAll() as $c) {

                // Create a new CommonUser object
                $chef = new Chef(
                    intval($c["chef_id"]), 
                );
                // Add the new CommonUser object to the array
                array_push($chefList, $chef);
            }
                
            return $chefList;
        }
        

        
    }

?>