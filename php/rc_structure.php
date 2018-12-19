<?php
    abstract class return_code {
        public function print_json() {
            echo json_encode($this);
        }
    }

    class success_code extends return_code {
        public $success;
        public $payload;

        function __construct($message, $content) {
            $this->success = $message;
            $this->payload = $content;
        }
    }
    
    class error_code extends return_code {
        public $error;

        function __construct($message) {
            $this->error = $message;
        }
    }