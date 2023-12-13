<?php
    require_once(__DIR__ . '/../database/connection.db.php');

    class Chef {
        public $id;
        //public $course_name;
        //public $school_name;
        //public $graduation_date;
        //public $academic_level;


        /* Constructor */
        public function __construct($id) {
            $this->id = $id;
            // $this->course_name;
            // $this->$school_name;
            // $this->$graduation_date;
            // $this->$academic_level;

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

        public static function getChefFormation($user_id)
        {
            $graduation_date;
            $course_name;
          $db = Database::getDatabase();
          $query = 'SELECT Formation.course_name, Formation.school_name, Formation.academic_level , Formation.graduation_date, ChefFormation.chef_id 
          FROM Formation 
          JOIN ChefFormation 
          ON Formation.course_name=ChefFormation.course_name AND Formation.school_name=ChefFormation.school_name 
          WHERE chef_id = :chef_id';
          
          $stmt = $db->prepare($query);
          $stmt->bindParam(':chef_id',$user_id,PDO::PARAM_INT);
          //$stmt->execute([$user_id]);
          $stmt->execute();


          while ($chefform = $stmt->fetch()) {
            $values = [$chefform['graduation_date'],
            $chefform['course_name'],
            $chefform['school_name'],
            $chefform['academic_level']];
        }
        return $values;
        
        
         /*  $stmt->execute(array($user_id));
        
          $chefform = $stmt->fetch();
      
           */
          
        }
        
        
        

        
    }

?>