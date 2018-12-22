<?php   
    include_once(__DIR__ . '/controller.php');

    if (!isset($_SESSION['login'])) {
        $rc = new error_code("Session has expired.");
    }

    else if (!isset($_POST['id1']) || !isset($_POST['id2']) || !isset($_COOKIE['last_visited_list'])) {
        $rc = new error_code("Missing parameters.");
    }

    else {
        $login = $_SESSION['login'];
        $list_id = htmlspecialchars($_COOKIE['last_visited_list']);   
        $id1 = htmlspecialchars($_POST['id1']);  
        $id2 = htmlspecialchars($_POST['id2']);  

        try {
            $request = new mysqli_request();
            $result = $request->swap_items($id1, $id2, $list_id, $login);
            $rc = new success_code("Items swapped successfully.", $result);
        }
        catch (Exception $e) {
            $rc = new error_code(htmlspecialchars($e->getMessage()));
        }
    }