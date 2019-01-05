<?php   
    include_once(__DIR__ . '/controller.php');

    if (!isset($_SESSION['login'])) {
        $rc = new error_code("Session has expired.");
    }

    else if (!isset($_POST['item']) || !isset($_COOKIE['last_visited_list']) || !isset($_POST['amount'])) {
        $rc = new error_code("Missing parameters.");
    }

    else {
        $login = $_SESSION['login'];
        $list_id = $_COOKIE['last_visited_list'];   
        $item = $_POST['item'];     
        $amount = $_POST['amount'];      
        
        try {
            if (empty($item) || empty($amount)) {
                throw new Exception("None of the values can be empty.");
            }

            if (!is_numeric($amount) || ((int)$amount) < 1) {
                throw new Exception("Unable to add item, invalid argument.");
            }
            
            $request = new mysqli_request();
            $result = $request->add_item($item, $amount, $list_id, $login);
            $rc = new success_code("Item added successfully.", array('name' => htmlspecialchars($item), 'id' => $result, 'login' => htmlspecialchars($login)));
        }
        catch (Exception $e) {
            $rc = new error_code(htmlspecialchars($e->getMessage()));
        }
    }