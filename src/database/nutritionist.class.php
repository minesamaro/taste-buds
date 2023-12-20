<?php
    require_once(__DIR__ . '/../database/connection.db.php');

    class Nutritionist {
        public $id;

        /* Constructor */
        public function __construct($id) {
            $this->id = $id;          
        }
        
        /**
        * Add a nutritionist to the database along with associated formation details.
        *
        * @param int $user_id User ID
        * @param string $course_name Name of the course
        * @param string $school_name Name of the school
        * @param string $graduation_date Graduation date
        * @param string $academic_level Academic level achieved
        * @return void
        */
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
                $stmt = $db->prepare('INSERT INTO NutritionistFormation (nutritionist_id, course_name, school_name) VALUES (?,?,?)');        
                $stmt->execute(array($user_id, $course_name, $school_name));
                $db->commit();
            }
        
            catch (Exception $e) {
                $db->rollBack();
                echo "Error: " . $e->getMessage();
            }
        } 

        /**
         * Retrieve formation details for a nutritionist by user ID.
         *
         * @param int $user_id User ID
         * @return array Array containing graduation date, course name, school name, and academic level
         */
        public static function getNutriFormation($user_id)
        {
            
          $db = Database::getDatabase();
        //   $query = 'SELECT Formation.course_name, Formation.school_name, Formation.academic_level , Formation.graduation_date, NutritionistFormation.nutritionist_id 
        //   FROM Formation 
        //   JOIN NutritionistFormation 
        //   ON Formation.course_name=NutritionistFormation.course_name AND Formation.school_name=NutritionistFormation.school_name 
        //   WHERE nutritionist_id = :nutritionist_id';
          
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
        /**
         * Update nutritionist information in the database.
         *
         * @param int $user_id User ID
         * @param string $course_name Name of the course
         * @param string $school_name Name of the school
         * @param string $academic_level Academic level achieved
         * @param string $graduation_date Graduation date
         * @return void
         */
        public static function changeNutriInfo($user_id,$course_name,$school_name,$academic_level,$graduation_date){
       
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

         /* Get array of Nutritionists
        *
        * @return array of Nutritionists
        */
        public static function getNutris() {
            $nutriList = array();
            $db = Database::getDatabase();
            $req = $db->query('SELECT Person.*, Nutritionist.* 
            FROM Person
            JOIN Nutritionist ON Person.id = Nutritionist.nutri_id');

            // Include the Person attributes
            foreach($req->fetchAll() as $n) {

                // Create a new CommonUser object
                $nutri = new Nutritionist(
                    intval($n["nutri_id"]), 
                );
                // Add the new CommonUser object to the array
                array_push($nutriList, $nutri);
            }
                
            return $nutriList;
        }
        /**
         * Retrieve weekly plans associated with a nutritionist by user ID.
         *
         * @param int $user_id User ID
         * @return array Array of WeeklyPlan objects
         */
        public static function getPlansByNutriId($user_id):array
        {
            try {

                #start transaction to the database
                $db = Database::getDatabase();       
                $stmt = $db->prepare(
                    'SELECT id, creation_date, total_kcal, common_user_id
                    FROM WeeklyPlan
                    WHERE nutritionist_id = ?');
                $stmt->execute(array($user_id));
     
            } catch (Exception $e) {
                $db->rollBack();
                echo "Error: " . $e->getMessage();
            }
            
            $plans = $stmt->fetchAll();
            $plansArray = array();
            foreach ($plans as $plan) {
              array_push($plansArray, new WeeklyPlan(
                intval($plan['id']),
                $plan['creation_date'],
                floatval($plan['total_kcal']),
                $user_id,
                intval($plan['common_user_id'])
              )
              );
            }
            return $plansArray;
            
        }

    }

?>