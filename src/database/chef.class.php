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
                $stmt = $db->prepare('INSERT INTO Formation (user_id,course_name, school_name, academic_level, graduation_date) VALUES (?,?,?,?,?)');        
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
        /**
        * Get chef's formation by ID
        *
        * @param int $userId user ID
        * @return array Array of formation values
        */
        public static function getChefFormation($userId)
        {
            $db = Database::getDatabase();
            $query = 'SELECT course_name, school_name, academic_level , graduation_date
            FROM Formation 
            WHERE user_id = ?';

            $stmt = $db->prepare($query);

            $stmt->execute([$userId]);

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

        /**
        * Update profile data to the database
        *
        * @param int $user_id User ID
        * @param string $course_name Name of the course
        * @param string $school_name Name of the school
        * @param string $academic_level Academic level achieved
        * @param string $graduation_date Graduation date
        * @return void
        */

        public static function changeChefInfo($user_id,$course_name,$school_name,$academic_level,$graduation_date){
       
            try {

                #start transaction to the database
                $db = Database::getDatabase();       
            
                $db->beginTransaction();
        
                # insert Person - using post variables from forms (note that the id is automatically set with autoincremental)
                $stmt = $db->prepare(
                    'UPDATE Formation
                    SET course_name = ? , school_name = ?,academic_level=?,graduation_date=?
                    WHERE user_id = ?');
                $stmt->execute(array($course_name, $school_name,$academic_level,$graduation_date,$user_id));
                $db->commit();
            } catch (Exception $e) {
                $db->rollBack();
                echo "Error: " . $e->getMessage();
            }
        }
        
    }

?>