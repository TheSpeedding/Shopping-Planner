<?php
    include(__DIR__ . '/db_config.php');

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

        /**
         * Processes the query and returns the result.
         */
        private function process_query($query) {
            if ($result = $this->mysqli->query($query)) {
                if ($result === TRUE) { // Insertion.
                    return $this->mysqli->insert_id;
                }
                else {
                    return $result;
                }
            }
            else {
                throw new Exception("Unable to process a query.");
            }
        }

        /**
         * Sanitizes the string so it is ready to be inserted into the database.
         */
        private function sanitize($item) {
            return $this->mysqli->escape_string($item);
        }

        /**
         * Fetches all the items and returns item entries as stored in the database.
         */
        public function fetch_items() {
            $result = $this->process_query("SELECT * FROM `items`");
            $items = array();

            while ($row = $result->fetch_assoc()) {
                $items[] = $row;
            }

            return $items;
        }

        private function get_account_id($login) {
            $login = $this->sanitize($login);

            $account = $this->process_query("SELECT * FROM `accounts` WHERE `login`='${login}'");
            $account_entry = $account->fetch_assoc();

            if ($account_entry == NULL) {
                die("Internal logic error. Account with given login not found.");
            }

            return $account_entry['id'];
        }

        /**
         * SIgns the user up and returns ID of the account.
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
            $account_id = $this->get_account_id($login);

            $result = $this->process_query("SELECT * FROM `lists` WHERE `account_id`=${account_id}");

            $lists = array();
            while ($row = $result->fetch_assoc()) {
                $lists[] = $row;
            }

            return $lists;
        }

        /**
         * Creates a new list and returns ID of the list;
         */
        public function create_new_list($name, $login) {
            $account_id = $this->get_account_id($login);

            return $this->process_query("INSERT INTO `lists` (`account_id`, `name`) VALUES ('${account_id}', '${name}')");
        }

        /**
         * Returns a list with given ID as stored in the database. Login is passed just to verify if it matches the list.
         */
        public function load_list($login, $id) {
            $account_id = $this->get_account_id($login);

            $list = $this->process_query("SELECT * FROM `lists` WHERE `id`=${id} AND `account_id`=${account_id}");
            $list_result = $list->fetch_assoc();

            if ($list_result == NULL) {
                throw new Exception("Selected list is not associated with current login.");
            }

            $result = $this->process_query("SELECT * FROM `list` WHERE `list_id`=${id}");

            $list_items = array();
            while ($row = $result->fetch_assoc()) {
                $list_items[] = $row;
            }

            return array(
                "name" => $list_result['name'], 
                "created" => $list_result['created'], 
                "items" => $list_items
            );
        }
    }