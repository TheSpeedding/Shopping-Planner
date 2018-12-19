<?
    include_once('php/controllers/controller_base.php');

    class controller extends controller_base {
        private $login;
        private $pw;

        function __construct($arr) {
            $this->login = htmlspecialchars(array_shift($arr));
            $this->pw = htmlspecialchars(array_shift($arr));
        }

        public function process() {       
            $request = new mysqli_request();
            $result = $request->log_in($this->login, $this->pw);            

            $_SESSION['login'] = $result['login'];
            $_SESSION['name'] = $result['name'];

            return "You was successfully logged-in.";
        }
    }