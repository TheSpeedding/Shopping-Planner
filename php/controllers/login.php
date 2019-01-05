<?php
    include_once(__DIR__ . '/controller.php');

    if (!isset($_POST['login']) || !isset($_POST['pw'])) {
        $rc = new error_code("Missing parameters.");
    }

    else {
        $login = $_POST['login'];
        $pw = $_POST['pw'];
        
        try {
            $request = new mysqli_request();
            $result = $request->log_in($login, $pw);  
    
            $_SESSION['login'] = $result['login'];
            $_SESSION['name'] = $result['name'];

            setcookie("session", session_id());
    
            $rc = new success_code("You was successfully logged-in.", array(
                'name' => htmlspecialchars($_SESSION['name']),
                'login' => htmlspecialchars($_SESSION['login']), 
                'pw' => htmlspecialchars($pw), 
                'session' => session_id())
            );
        } 
        catch (Exception $e) {
            $rc = new error_code(htmlspecialchars($e->getMessage()));
        }
    }