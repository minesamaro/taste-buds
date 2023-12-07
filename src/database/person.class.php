<?php  
    require_once(__DIR__ . '/../database/connection.db.php');

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
                // Assuming 'chefs' is the table name for chefs
                $query = 'SELECT COUNT(*) FROM Chef WHERE chef_id = ?';
                $stmt = $db->prepare($query);
                $stmt->execute([$user_id]);

                $count = $stmt->fetchColumn();
                // If count is greater than 0, the user_id exists in the Chef table
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
                // Assuming 'common_users' is the table name for common users
                $query = 'SELECT COUNT(*) FROM CommonUser WHERE id = ?';
                $stmt = $db->prepare($query);
                $stmt->execute([$user_id]);

                $count = $stmt->fetchColumn();
                //var_dump($query, [$user_id]);  // Add this line for debugging
                //var_dump($count);  // Add this line for debugging
                // If length count is greater than 0, the user_id exists in the CommonUser table
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
                $query = 'SELECT COUNT(*) FROM Nutritionist WHERE id = ?';
                $stmt = $db->prepare($query);
                $stmt->execute([$user_id]);

                $count = $stmt->fetchColumn();
                // If count is greater than 0, the user_id exists in the Nutritionist table
                return $count > 0;
            } catch (PDOException $e) {
                // Handle database errors appropriately
                return false;
            }
        }

    }

?>