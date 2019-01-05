<?php   
    include_once(__DIR__ . '/controller.php');

    if (!isset($_SESSION['login'])) {
        $rc = new error_code("Session has expired.");
    }

    else if (!isset($_POST['id'])) {
        $rc = new error_code("Missing parameters.");
    }

    else {
        $login = $_SESSION['login'];
        $id = $_POST['id'];    
        
        try {
            $request = new mysqli_request();
            $result = $request->delete_list($id, $login);
            $rc = new success_code("List deleted successfully.", $result);
        }
        catch (Exception $e) {
            $rc = new error_code(htmlspecialchars($e->getMessage()));
        }
    }