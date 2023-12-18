<?php  
    require_once(__DIR__ . '/../database/connection.db.php');
    require_once(__DIR__ . '/../database/chef.class.php');
    require_once(__DIR__ . '/../database/nutritionist.class.php');
    require_once(__DIR__ . '/../database/commonUser.class.php');

    class Person {
        public $id;
        public $username;
        public $first_name;
        public $surname;
        public $email;
        public $password;
        public $birth_date;
        public $gender;

        /* Constructor */
        public function __construct($id, $username, $first_name, $surname, $email, $password, $birth_date, $gender) {
            $this->id = $id;
            $this->username = $username;
            $this->first_name = $first_name;
            $this->surname = $surname;
            $this->email = $email;
            $this->password = $password;
            $this->birth_date = $birth_date;
            $this->gender = $gender;            
        }
        public function getId() {
            return $this->id;
        }
        public function getUsername() {
            return $this->username;
        }
        public function getFirstName() {
            return $this->first_name;
        }
        public function getSurname() {
            return $this->surname;
        }
        public function getEmail() {
            return $this->email;
        }
        public function getPassword() {
            return $this->password;
        }
        public function getBirthDate() {
            return $this->birth_date;
        }
        public function getGender() {
            return $this->gender;
        }

        static function addPerson($username, $first_name, $surname, $email, $password, $birth_date, $gender, $occupation) : Person {

            try {

                #start transaction to the database
                $db = Database::getDatabase();       
            
                $db->beginTransaction();
        
                # insert Person - using post variables from forms (note that the id is automatically set with autoincremental)
                $stmt = $db->prepare('INSERT INTO Person (username,first_name,surname,email,password,birth_date,gender) VALUES (?,?,?,?,?,?,?)');
                $stmt->execute(array($username, $first_name, $surname, $email, hash('sha256', $password), $birth_date, $gender));
                
                $db->commit();

            } catch (Exception $e) {
                $db->rollBack();
                echo "Error: " . $e->getMessage();
            }

            $new_person = new Person(
                intval($db->lastInsertId()), 
                $username,
                $first_name,
                $surname,
                $email,
                hash('sha256', $password),
                $birth_date, 
                $gender
            );

            return $new_person;

        }

        static function getAllPersons() {
            $db = Database::getDatabase();

            $persons = array();
            $stmt = $db->prepare(
                'SELECT *
                FROM Person');
            $stmt->execute();

            $personsData = $stmt->fetchAll();
            foreach ($personsData as $p) {
                array_push ($persons, new Person(
                    intval($p['id']),
                    $p['username'],
                    $p['first_name'],
                    $p['surname'],
                    $p['email'],
                    $p['password'],
                    $p['birth_date'],
                    $p['gender']
                ));
            }

            return $persons;
        }

        static function getPersonByUsername(string $username) : Person {
            $db = Database::getDatabase();
            $stmt = $db->prepare(
                'SELECT id, username, first_name, surname, email, password, birth_date, gender
                FROM Person
                WHERE username = ?');
        
            $stmt->execute(array($username));
        
            $person = $stmt->fetch();
        
            return new Person(
                intval($person['id']), 
                $person['username'],
                $person['first_name'],
                $person['surname'],
                $person['email'],
                $person['password'],
                $person['birth_date'], 
                $person['gender']
            );
        }

        static function getPersonById(int $user_id) : Person {
            $db = Database::getDatabase();
            $stmt = $db->prepare(
                'SELECT id, username, first_name, surname, email, password, birth_date, gender
                FROM Person
                WHERE id = ?');
        
            $stmt->execute(array($user_id));
        
            $person = $stmt->fetch();
        
            return new Person(
                intval($person['id']), 
                $person['username'],
                $person['first_name'],
                $person['surname'],
                $person['email'],
                $person['password'],
                $person['birth_date'], 
                $person['gender']
            );
        }

        public static function getPeopleByOccupations($selectedOccupations) {
            $people_occupation = array();
    
            foreach ($selectedOccupations as $occupation) {
                switch ($occupation) {
                    case 'Chef':
                        $chefPeople = Chef::getChefs();
                        $people_occupation = array_merge($people_occupation, $chefPeople);
                        break;
    
                    case 'Nutritionist':
                        $nutritionistPeople = Nutritionist::getNutris();
                        $people_occupation = array_merge($people_occupation, $nutritionistPeople);
                        break;
    
                    case 'Common User':
                        $commonUserPeople = CommonUser::getUsers();
                        $people_occupation = array_merge($people_occupation, $commonUserPeople);
                        break;
                }
            }

            $people = array();

            foreach ($people_occupation as $p) {
                $person = self::getPersonById($p->id);
                array_push ($people, $person);
            }

            return $people;
        }



        
         # nao sei se isto deva ficar aqui ou no ficheiro das funcoes (o msm para as outras classes)
        static function checkPersonLogin(string $username, string $password) : Person {
            $db = Database::getDatabase();
            $stmt = $db->prepare('SELECT * FROM Person WHERE username = ? AND password = ?'); #isto ou vem como 1 (max) ou 0 (vazio) se nao existir na base de dados
            $stmt->execute(array($username, hash('sha256', $password))); 
            
            if ($stmt->fetch()) { # se select vier vazio o fetch vai dar booleano falso
                return new Person(
                    intval($user['id']),
                    $user['username'],
                    $user['first_name'],
                    $user['surname'],
                    $user['email'],
                    $user['password'],
                    $user['birth_date'],
                    $user['gender']
                );
            }

            return null; # meter que se for null e meter a msg de erro de $_SESSION
        }

        public static function isChef($user_id)
        {
            $db = Database::getDatabase();
            try {
                // Assuming 'nutritionists' is the table name for nutritionists
                $query = 'SELECT COUNT(*) FROM Chef WHERE chef_id = :user_id';
                $stmt = $db->prepare($query);  // Prepare the query

                // Bind the parameter
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

                // Execute the query
                $stmt->execute();

                $count = $stmt->fetchColumn();
                // If count is greater than 0, the user_id exists in the Nutritionist table
                return $count > 0;
            } catch (PDOException $e) {
                // Handle database errors appropriately
                return false;
            }
        }

        public static function isCommonUser($user_id)
        {
            $db = Database::getDatabase();
            try {
                // Assuming 'nutritionists' is the table name for nutritionists
                $query = 'SELECT COUNT(*) FROM CommonUser WHERE id = :user_id';
                $stmt = $db->prepare($query);  // Prepare the query

                // Bind the parameter
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

                // Execute the query
                $stmt->execute();

                $count = $stmt->fetchColumn();
                // If count is greater than 0, the user_id exists in the Nutritionist table
                return $count > 0;
            } catch (PDOException $e) {
                // Handle database errors appropriately
                return false;
            }
        }

        public static function isNutritionist($user_id)
        {
            $db = Database::getDatabase();
            try {
                // Assuming 'nutritionists' is the table name for nutritionists
                $query = 'SELECT COUNT(*) FROM Nutritionist WHERE nutri_id = :user_id';
                $stmt = $db->prepare($query);  // Prepare the query

                // Bind the parameter
                $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

                // Execute the query
                $stmt->execute();

                $count = $stmt->fetchColumn();
                // If count is greater than 0, the user_id exists in the Nutritionist table
                return $count > 0;
            } catch (PDOException $e) {
                // Handle database errors appropriately
                return false;
            }
        }

        public static function changePersonInfo( $firstName, $surname, int $user_id)
        {
            try {

                #start transaction to the database
                $db = Database::getDatabase();       
            
                $db->beginTransaction();
        
                # Change the information on the Person table in the Database
                $stmt = $db->prepare(
                    'UPDATE Person
                    SET first_name=?,surname=?
                    WHERE id = ?');
                $stmt->execute(array($firstName, $surname,$user_id));
                $db->commit();
            } catch (Exception $e) {
                $db->rollBack();
                echo "Error: " . $e->getMessage();
            }
        }

    }

?>