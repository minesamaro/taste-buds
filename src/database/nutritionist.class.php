<?php
    require_once(__DIR__ . '/../database/database.class.php');

    class Nutritionist {
        private $id;

        /* Constructor */
        public function __construct($id) {
            $this->id = $id;          
        }
        public function getId() {
            return $this->id;
        }

    }

?>