<?php  
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/person.class.php');

    // CommonUser extends Person

    class CommonUser extends Person {
        public $id;
        public $height;
        public $current_weight;
        public $ideal_weight;
        public Person $person;

        /* Constructor */
        public function __construct($id, $height, $current_weight, $ideal_weight) {
            $this->id = $id;
            $this->height = $height;
            $this->current_weight = $current_weight;
            $this->ideal_weight = $ideal_weight;

            $this->person =parent::getPersonById($id);
        }

        public function getId() {
            return $this->id;
        }
        public function getHeight() {
            return $this->height;
        }
        public function getCurrentWeight() {
            return $this->current_weight;
        }
        public function getIdealWeight() {
            return $this->ideal_weight;
        }

        # nao sei se isto deva ficar aqui ou no ficheiro das funcoes (o msm para as outras classes)
        static function addCommonUser($user_id, $height, $currentWeight, $idealWeight, $healthGoal) {
            $db = Database::getDatabase();
            
            try {
                $db->beginTransaction();
                $stmt = $db->prepare('INSERT INTO CommonUser (id, height, current_weight, ideal_weight) VALUES (?, ?, ?, ?)');        
                $stmt->execute(array($user_id, $height, $currentWeight, $idealWeight));
            
                $db->commit();
            }
        
            catch (Exception $e) {
                $db->rollBack();
                echo "Error: " . $e->getMessage();
            }

            try {
                $db->beginTransaction();
                $stmt = $db->prepare('INSERT INTO UserHealthGoal (user_id, health_goal_name) VALUES (?, ?)');        
                $stmt->execute(array($user_id, $healthGoal));
            
                $db->commit();
            }
        
            catch (Exception $e) {
                $db->rollBack();
                echo "Error: " . $e->getMessage();
            }
        }
        
        /* Get array of Users 
        *
        * @return array of Users
        */
        public static function getUsers() {
            $userList = array();
            $db = Database::getDatabase();
            $req = $db->query('SELECT Person.*, CommonUser.* 
            FROM Person
            JOIN CommonUser ON Person.id = CommonUser.id');

            

            // Include the Person attributes
            foreach($req->fetchAll() as $u) {

                // Create a new CommonUser object
                $user = new CommonUser(
                    intval($u["id"]), 
                    floatval($u["height"]), 
                    floatval($u["current_weight"]), 
                    floatval($u["ideal_weight"]),
                );
                // Add the new CommonUser object to the array
                array_push($userList, $user);
            }
            return $userList;
        }
        
        static function getCommonUserById($user_id): CommonUser {
            $db = Database::getDatabase();
            $stmt = $db->prepare(
                'SELECT id, height, current_weight, ideal_weight
                FROM CommonUser
                WHERE id = ?');
        
            $stmt->execute(array($user_id));
        
            $commonUser = $stmt->fetch();
        
            return new CommonUser(
                intval($commonUser['id']), 
                $commonUser['height'],
                $commonUser['current_weight'],
                $commonUser['ideal_weight'],
              
                
            );

        }
        public static function changeUserInfo($user_id,$height,$currentWeight,$idealWeight){
       
            try {

                #start transaction to the database
                $db = Database::getDatabase();       
            
                $db->beginTransaction();
        
                
                $stmt = $db->prepare(
                    'UPDATE CommonUser
                    SET height = ? , current_weight = ?,ideal_weight=?
                    WHERE id = ?');
                $stmt->execute(array($height, $currentWeight,$idealWeight,$user_id));
                $db->commit();
            } catch (Exception $e) {
                $db->rollBack();
                echo "Error: " . $e->getMessage();
            }
        
        }
        public static function getPlansByUserId($user_id):array
        {
            try {

                #start transaction to the database
                $db = Database::getDatabase();       
                $stmt = $db->prepare(
                    'SELECT id, creation_date, total_kcal, nutritionist_id
                    FROM WeeklyPlan
                    WHERE common_user_id = ?');
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
                intval($plan['nutritionist_id']),
                $user_id
              )
              );
            }
            return $plansArray;
            
        }
    }

    ?>