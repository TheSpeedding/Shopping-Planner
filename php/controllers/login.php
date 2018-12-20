<?php
    include_once(__DIR__ . '/controller.php');

    if (!isset($_POST['login']) || !isset($_POST['pw'])) {
        $rc = new error_code("Missing parameters.");
    }

    else {
        $login = htmlspecialchars($_POST['login']);
        $pw = htmlspecialchars($_POST['pw']);
        
        if (empty($login) || empty($pw)) {
            throw new Exception("None of the values can be empty.");
        }
        
        else {
            try {
                $request = new mysqli_request();
                $result = $request->log_in($login, $pw);  
        
                $_SESSION['login'] = $result['login'];
                $_SESSION['name'] = $result['name'];

                setcookie("session", session_id());
        
                $rc = new success_code("You was successfully logged-in.", array('login' => $login, 'pw' => $pw, 'session' => session_id()));
            } 
            catch (Exception $e) {
                $rc = new error_code(htmlspecialchars($e->getMessage()));
            }
        }
    }