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
        $list_id = htmlspecialchars($_COOKIE['last_visited_list']);   
        $item = htmlspecialchars($_POST['item']);     
        $amount = htmlspecialchars($_POST['amount']);      
        
        if (empty($item)) {
            throw new Exception("None of the values can be empty.");
        }

        else {
            try {
                $request = new mysqli_request();
                $result = $request->add_item($item, $amount, $list_id, $login);
                $rc = new success_code("Item added successfully.", array('name' => $item, 'id' => $result, 'login' => $login));
            }
            catch (Exception $e) {
                $rc = new error_code(htmlspecialchars($e->getMessage()));
            }
        }
    }