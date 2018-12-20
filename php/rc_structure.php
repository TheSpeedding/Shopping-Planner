<?php
    abstract class return_code {
        public function print_json() {
            echo json_encode($this);
        }

        public abstract function getMessage();
    }

    class success_code extends return_code {
        public $success;
        public $payload;

        function __construct($message, $content) {
            $this->success = $message;
            $this->payload = $content;
        }

        public function getMessage() {
            return $this->success;
        }
    }
    
    class error_code extends return_code {
        public $error;

        function __construct($message) {
            $this->error = $message;
        }

        public function getMessage() {
            return $this->error;
        }
    }