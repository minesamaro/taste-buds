<?php  
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/person.class.php');

    // CommonUser extends Person

    class CommonUser extends Person {
        public $id;
        public $height;
        public $current_weight;
        public $ideal_weight;

        /* Constructor */
        public function __construct($id, $height, $current_weight, $ideal_weight) {
            // Get parent information from database
            $db = Database::getDatabase();
            $req = $db->prepare('SELECT * FROM Person WHERE id = ?');
            $req->execute(array($id));
            $user = $req->fetch();
            
            if ($user != null){
                parent::__construct($user->id,
                $user->username,
                $user->first_name,
                $user->surname,
                $user->email,
                $user->password,
                $user->birth_date,
                $user->gender);
            }
            else {
                parent::__construct($id, null, null, null, null, null, null, null);
            }
            $this->height = floatval($height);
            $this->current_weight = floatval($current_weight);
            $this->ideal_weight = floatval($ideal_weight);
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
            foreach($req->fetchAll() as $user) {
                $userList.array_push($user, new CommonUser(
                    intval($user['id']), 
                    floatval($user['height']), 
                    floatval($user['current_weight']), 
                    floatval($user['ideal_weight']),
                )); 
                print_r($userList[-1]['id']);
            }
            var_dump($userList);
            return $userList;
        }
    }

    ?>