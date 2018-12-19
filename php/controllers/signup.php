<?php
    include_once(__DIR__ . '/controller.php');

    if (!isset($_POST['fullname']) || !isset($_POST['login']) || !isset($_POST['pw'])) {
        $rc = new error_code("Missing POST parameters.");
    }

    else {
        $fullname = htmlspecialchars($_POST['fullname']);
        $login = htmlspecialchars($_POST['login']);
        $pw = htmlspecialchars(password_hash($_POST['pw'], PASSWORD_DEFAULT));
    
        try {
            $request = new mysqli_request();
            $result = $request->sign_up($fullname, $login, $pw);
            $rc = new success_code("You was successfully signed-up.", array('fullname' => $result['fullname'], 'login' => $result['login'], 'name' => $result['name']));
        }
        catch (Exception $e) {
            $rc = new error_code(htmlspecialchars($e->getMessage()));
        }
    }