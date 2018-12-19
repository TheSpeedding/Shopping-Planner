<?php

    include('db/db_config.php');

    class mysqli_request {
        private $mysqli = NULL;

        function __construct() {
            global $db_config; // Defined in a particular file.

            $this->mysqli = new mysqli($db_config['server'], $db_config['login'], $db_config['password'], $db_config['database']);
        
            if ($this->mysqli->connect_error) {
                throw new Exception('Unable to connect to the database.');
            }
        }

        function __destruct() {
            $this->mysqli->close();
        }

        private function process_generic($query) {
            if ($result = $this->mysqli->query($query)) {
                return $result;
            }
            else {
                throw new Exception("Unable to process a query.");
            }
        }

        public function fetch_items() {
            return $this->process_generic("SELECT `name` FROM `items`");
        }
    }