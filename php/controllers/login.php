<?php
    include_once(__DIR__ . '/controller.php');

    if (!isset($_POST['login']) || !isset($_POST['pw'])) {
        $rc = new error_code("Missing POST parameters.");
    }

    else {
        $login = htmlspecialchars($_POST['login']);
        $pw = htmlspecialchars($_POST['pw']);
        
        try {
            $request = new mysqli_request();
            $result = $request->log_in($login, $pw);  
    
            $_SESSION['login'] = $result['login'];
            $_SESSION['name'] = $result['name'];
    
            $rc = new success_code("You was successfully logged-in.", array('login' => $result['login'], 'name' => $result['name']));
        } 
        catch (Exception $e) {
            $rc = new error_code(htmlspecialchars($e->getMessage()));
        }
    }