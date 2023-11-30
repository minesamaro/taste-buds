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

    }

?>