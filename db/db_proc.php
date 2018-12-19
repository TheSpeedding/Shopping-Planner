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

        private function process_query($query) {
            if ($result = $this->mysqli->query($query)) {
                return $result;
            }
            else {
                throw new Exception("Unable to process a query.");
            }
        }

        private function sanitize($item) {
            return $this->mysqli->escape_string($item);
        }

        public function fetch_items() {
            return $this->process_query("SELECT `name` FROM `items`");
        }

        public function sign_up($fullname, $login, $pw) {
            $fullname = $this->sanitize($fullname);
            $login = $this->sanitize($login);
            $pw = $this->sanitize($pw);

            $result = $this->process_query("SELECT `login` FROM `accounts` WHERE `login`='${login}'");
            if ($result->fetch_assoc() != NULL) {
                throw new Exception("Username already exists.");
            }
            
            return $this->process_query("INSERT INTO `accounts` (`name`, `login`, `pw`) VALUES ('${fullname}', '${login}', '${pw}')");
        }
    }