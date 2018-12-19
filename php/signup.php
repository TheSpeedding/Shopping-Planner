<?
    include('php/controller_base.php');

    class controller extends controller_base {
        private $fullname;
        private $login;
        private $pw;

        function __construct($arr) {
            $this->fullname = array_shift($arr);
            $this->login = array_shift($arr);
            $this->pw = password_hash(array_shift($arr), PASSWORD_DEFAULT);
        }

        public function process() {       
            $request = new mysqli_request();
            $result = $request->sign_up($this->fullname, $this->login, $this->pw);
            return "You have been successfully signed-up.";
        }
    }