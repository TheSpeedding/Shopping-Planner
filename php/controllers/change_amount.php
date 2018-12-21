<?php   
    include_once(__DIR__ . '/controller.php');

    if (!isset($_SESSION['login'])) {
        $rc = new error_code("Session has expired.");
    }

    else if (!isset($_POST['id']) || !isset($_POST['amount']) || !isset($_COOKIE['last_visited_list'])) {
        $rc = new error_code("Missing parameters.");
    }

    else {
        $login = $_SESSION['login'];
        $list_id = htmlspecialchars($_COOKIE['last_visited_list']);   
        $id = htmlspecialchars($_POST['id']);  
        $amount = htmlspecialchars($_POST['amount']);          

        try {
            if (empty($amount)) {
                throw new Exception("None of the values can be empty.");
            }

            if (!is_numeric($amount) || ((int)$amount) < 1) {
                throw new Exception("Unable to edit item, invalid argument.");
            }
            
            $request = new mysqli_request();
            $result = $request->change_amount($id, $amount, $list_id, $login);
            $rc = new success_code("Item edited successfully.", $result);
        }
        catch (Exception $e) {
            $rc = new error_code(htmlspecialchars($e->getMessage()));
        }
    }