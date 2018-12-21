<?php
    include_once(__DIR__ . '/controller.php');

    if (!isset($_POST['fullname']) || !isset($_POST['login']) || !isset($_POST['pw'])) {
        $rc = new error_code("Missing parameters.");
    }

    else {
        $fullname = htmlspecialchars($_POST['fullname']);
        $login = htmlspecialchars($_POST['login']);
        $pw = htmlspecialchars(password_hash($_POST['pw'], PASSWORD_DEFAULT));

        try {
            if (empty($fullname) || empty($login) || empty($pw)) {
                throw new Exception("None of the values can be empty.");
            }

            $request = new mysqli_request();
            $result = $request->sign_up($fullname, $login, $pw);
            $rc = new success_code("You was successfully signed-up.", array('fullname' => $fullname, 'login' => $login, 'pw' => $pw, 'id' => $result));
        }
        catch (Exception $e) {
            $rc = new error_code(htmlspecialchars($e->getMessage()));
        }
    }