<?php
    include_once(__DIR__ . '/controller.php');

    if (!isset($_SESSION['login'])) {
        $rc = new error_code("Session has expired.");
    }

    else {
        $login = $_SESSION['login'];

        try {                
            $request = new mysqli_request();
            $lists = $request->fetch_lists($login);    
            $rc = new success_code("Lists fetched successfully.", $lists);
        }
    
        catch (Exception $e) {
            $rc = new error_code(htmlspecialchars($e->getMessage()));            
        }
    }