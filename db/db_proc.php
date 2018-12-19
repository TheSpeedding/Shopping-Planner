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

        /**
         * Returns an array with item names.
         */
        public function fetch_items() {
            $result = $this->process_query("SELECT `name` FROM `items`");
            $items = array();

            while ($row = $result->fetch_assoc()) {
                $items[] = $row['name'];
            }

            return $items;
        }

        /**
         * Returns true if succeeded.
         */
        public function sign_up($fullname, $login, $pw) {
            $fullname = $this->sanitize($fullname);
            $login = $this->sanitize($login);
            $pw = $this->sanitize($pw);

            $result = $this->process_query("SELECT * FROM `accounts` WHERE `login`='${login}'");
            if ($result->fetch_assoc() != NULL) {
                throw new Exception("Username already exists.");
            }
            
            return $this->process_query("INSERT INTO `accounts` (`name`, `login`, `pw`) VALUES ('${fullname}', '${login}', '${pw}')");
        }

        /**
         * Returns an account entry as stored in the database.
         */
        public function log_in($login, $pw) {
            $login = $this->sanitize($login);
            $pw = $this->sanitize($pw);

            $result = $this->process_query("SELECT * FROM `accounts` WHERE `login`='${login}'");
            $entry = $result->fetch_assoc();

            if ($entry == NULL) {
                throw new Exception("Username does not exist.");
            }
            
            if (!password_verify($pw, $entry['pw'])) {
                throw new Exception("Incorrect password.");
            }

            return $entry;
        }

        /**
         * Fetches all the lists for given user and returns lists entries as stored in the database.
         */
        public function fetch_lists($login) {
            $login = $this->sanitize($login);

            $account = $this->process_query("SELECT * FROM `accounts` WHERE `login`='${login}'");
            $account_entry = $account->fetch_assoc();

            if ($account_entry == NULL) {
                throw new Exception("Internal logic error. Account with given login not found.");
            }

            $account_id = $account_entry['id'];

            $result = $this->process_query("SELECT * FROM `lists` WHERE `account_id`=${account_id}");

            $lists = array();
            while ($row = $result->fetch_assoc()) {
                $items[] = $row;
            }
            return $lists;
        }
    }