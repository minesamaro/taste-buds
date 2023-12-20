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
        public $profile_photo;
        public static $people_per_page = 5;

        /* Constructor */
        public function __construct($id, $username, $first_name, $surname, $email, $password, $birth_date, $gender, $profile_photo) {
            $this->id = $id;
            $this->username = $username;
            $this->first_name = $first_name;
            $this->surname = $surname;
            $this->email = $email;
            $this->password = $password;
            $this->birth_date = $birth_date;
            $this->gender = $gender;   
            if ($profile_photo == null) {
                $this->profile_photo = '/../img/users/profile.png';
            } else {
            $this->profile_photo = "/" . $profile_photo;
            }
        }
        
        /**
         * Add a new person to the database.
         *
         * @param string $username Username
         * @param string $first_name First name
         * @param string $surname Surname
         * @param string $email Email
         * @param string $password Password
         * @param string $birth_date Birth date
         * @param string $gender Gender
         * @param string $profile_photo Profile photo URL
         * @return Person Newly created Person object
         */
        static function addPerson($username, $first_name, $surname, $email, $password, $birth_date, $gender, $occupation, $profile_photo) : Person {

            try {

                #start transaction to the database
                $db = Database::getDatabase();       
            
                $db->beginTransaction();
        
                # insert Person - using post variables from forms (note that the id is automatically set with autoincremental)
                $stmt = $db->prepare('INSERT INTO Person (username,first_name,surname,email,password,birth_date,gender,profile_photo) VALUES (?,?,?,?,?,?,?,?)');
                $stmt->execute(array($username, $first_name, $surname, $email, hash('sha256', $password), $birth_date, $gender, $profile_photo));
                
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
                $gender,
                $profile_photo
            );

            return $new_person;

        }

        public static function deletePerson($user_id) {
            try {

                #start transaction to the database
                $db = Database::getDatabase();       
            
                $db->beginTransaction();

                # delete from Person
                $stmt = $db->prepare('DELETE FROM Person WHERE id = ?');
                $stmt->execute(array($user_id));

            } catch (Exception $e) {
                $db->rollBack();
                echo "Error: " . $e->getMessage();
            }
        }
        
                
        /**
         * Get a paginated list of all persons from the database.
         *
         * @param int $page Page number
         * @return array Array of Person objects
         */
        static function getAllPersons(int $page) : array {
            $db = Database::getDatabase();

            $persons = array();
            $stmt = $db->prepare(
                'SELECT *
                FROM Person
                ORDER BY id
                LIMIT ?
                OFFSET ?');
            $stmt->execute(array( self::$people_per_page, ($page - 1) * self::$people_per_page));

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
                    $p['gender'],
                    $p['profile_photo']
                ));
            }

            return $persons;
        }
        /**
         * Get a person from the database by username.
         *
         * @param string $username Username
         * @return Person Found Person object
         */
        static function getPersonByUsername(string $username) : Person {
            $db = Database::getDatabase();
            $stmt = $db->prepare(
                'SELECT id, username, first_name, surname, email, password, birth_date, gender, profile_photo
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
                $person['gender'],
                $person['profile_photo']
            );
        }
        /**
     * Get a person from the database by user ID.
     *
     * @param int $user_id User ID
     * @return Person Found Person object
     */
        static function getPersonById(int $user_id) : Person {
            $db = Database::getDatabase();
            $stmt = $db->prepare(
                'SELECT id, username, first_name, surname, email, password, birth_date, gender, profile_photo
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
                $person['gender'],
                $person['profile_photo']
            );
        }

        /**
         * Get the last person ID from the database.
         *
         * @return int Last person ID
         */
        static function getLastPersonId(): int
        {
            $db = Database::getDatabase();
            $stmt = $db->prepare(
            'SELECT id
                FROM Person
                ORDER BY id DESC
                LIMIT 1'
            );
            $stmt->execute();
            $result = $stmt->fetch();
            return intval($result['id']);
        
        }
        /**
         * Get people from different occupations based on selected occupations.
         *
         * @param array $selectedOccupations Array of selected occupations (e.g., ['Chef', 'Nutritionist', 'Common User'])
         * @return array Array of Person objects
         */
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

        /**
         * Search for people based on a search query.
         *
         * @param string $searchQuery Search query
         * @return array Array of Person objects matching the search query
         */
        public static function searchPeople($searchQuery)
        {
            $peopleList = array();
            $db = Database::getDatabase();

            // Use prepared statements to prevent SQL injection
            $stmt = $db->prepare('SELECT * FROM Person WHERE username LIKE ? OR first_name LIKE ? OR surname LIKE ?');
            $stmt->execute(["%$searchQuery%", "%$searchQuery%", "%$searchQuery%"]);

            // Fetch the results
            foreach ($stmt->fetchAll() as $person) {
                $peopleList[] = new Person(
                    intval($person["id"]),
                    $person["username"],
                    $person["first_name"],
                    $person["surname"],
                    $person["email"],
                    $person["password"],
                    $person["birth_date"],
                    $person["gender"],
                    $person["profile_photo"]
                );
            }

            return $peopleList;
        }

        /**
         * Check user login credentials and return the corresponding Person object.
         *
         * @param string $username Username
         * @param string $password Password
         * @return Person|null Found Person object or null if credentials are invalid
         */
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
                    $user['gender'],
                    $user['profile_photo']
                );
            }

            return null; # meter que se for null e meter a msg de erro de $_SESSION
        }
        /**
         * Check if a user with the given ID is a Chef.
         *
         * @param int $user_id User ID
         * @return bool True if the user is a Chef, false otherwise
         */
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
        /**
         * Check if a user with the given ID is a Common User.
         *
         * @param int $user_id User ID
         * @return bool True if the user is a Common User, false otherwise
         */
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
        /**
         * Check if a user is a nutritionist based on the user ID.
         *
         * @param int $user_id User ID
         * @return bool True if the user is a nutritionist, false otherwise
         */
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
        /**
         * Update personal information of a user in the Person table.
         *
         * @param string $firstName First name
         * @param string $surname Surname
         * @param string $profile_photo Profile photo URL
         * @param int $user_id User ID
         * @return void
         */
        public static function changePersonInfo( $firstName, $surname, $profile_photo, int $user_id)
        {
            try {

                #start transaction to the database
                $db = Database::getDatabase();       
            
                $db->beginTransaction();
        
                # Change the information on the Person table in the Database
                $stmt = $db->prepare(
                    'UPDATE Person
                    SET first_name=?,surname=?, profile_photo=?
                    WHERE id = ?');
                $stmt->execute(array($firstName, $surname,$profile_photo, $user_id));
                $db->commit();
            } catch (Exception $e) {
                $db->rollBack();
                echo "Error: " . $e->getMessage();
            }
        }
        /**
         * Change the password of a user in the Person table.
         *
         * @param int $user_id User ID
         * @param string $password New password
         * @return void
         */
        public static function changePassword( int $user_id, $password)
        {
            try {

                #start transaction to the database
                $db = Database::getDatabase();       
            
                $db->beginTransaction();
        
                # Change the information on the Person table in the Database
                $stmt = $db->prepare(
                    'UPDATE Person
                    SET password=?
                    WHERE id = ?');
                $stmt->execute(array($password, $user_id));
                $db->commit();
            } catch (Exception $e) {
                $db->rollBack();
                echo "Error: " . $e->getMessage();
            }
        }

        /**
        * Get the number of pages needed to display all the people.
        *
        * @return int Number of pages
        */
        static function getNumberOfPages(): int {
            $db = Database::getDatabase();
            $stmt = $db->prepare(
                'SELECT COUNT(*) AS count
                FROM Person'
            );
            $stmt->execute();
            $result = $stmt->fetch();
            return intval(ceil($result['count'] / Person::$people_per_page));
        }

    }

?>