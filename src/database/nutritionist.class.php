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

        static function addNutritionist($user_id, $course_name, $school_name, $graduation_date, $academic_level) {
            $db = Database::getDatabase();
            
            try {
                $db->beginTransaction();
                $stmt = $db->prepare('INSERT INTO Nutritionist (nutri_id) VALUES (?)');        
                $stmt->execute(array($user_id));
            
                $db->commit();
            }
        
            catch (Exception $e) {
                $db->rollBack();
                echo "Error: " . $e->getMessage();
            }

            try {
                $db->beginTransaction();
                $stmt = $db->prepare('INSERT INTO Formation (course_name, school_name, academic_level, graduation_date) VALUES (?,?,?,?)');        
                $stmt->execute(array($course_name, $school_name, $academic_level, $graduation_date));
                $db->commit();
            }
        
            catch (Exception $e) {
                $db->rollBack();
                echo "Error: " . $e->getMessage();
            }

            try {
                $db->beginTransaction();
                $stmt = $db->prepare('INSERT INTO NutritionistFormation (nutritionist_id, course_name, school_name) VALUES (?,?,?)');        
                $stmt->execute(array($user_id, $course_name, $school_name));
                $db->commit();
            }
        
            catch (Exception $e) {
                $db->rollBack();
                echo "Error: " . $e->getMessage();
            }
        } 

        
        public static function getNutriFormation($user_id)
        {
            
          $db = Database::getDatabase();
          $query = 'SELECT Formation.course_name, Formation.school_name, Formation.academic_level , Formation.graduation_date, NutritionistFormation.nutritionist_id 
          FROM Formation 
          JOIN NutritionistFormation 
          ON Formation.course_name=NutritionistFormation.course_name AND Formation.school_name=NutritionistFormation.school_name 
          WHERE nutritionist_id = :nutritionist_id';
          
          $stmt = $db->prepare($query);
          $stmt->bindParam(':nutritionist_id',$user_id,PDO::PARAM_INT);
          //$stmt->execute([$user_id]);
          $stmt->execute();


          while ($nutriform = $stmt->fetch()) {
            $values = [$nutriform['graduation_date'],
            $nutriform['course_name'],
            $nutriform['school_name'],
            $nutriform['academic_level']];
        }
        return $values;
          
        }

    }

?>