<?php
    include_once(__DIR__ . '/controller.php');

    if (!isset($_POST['fullname']) || !isset($_POST['login']) || !isset($_POST['pw'])) {
        $rc = new error_code("Missing parameters.");
    }

    else {
        $fullname = $_POST['fullname'];
        $login = $_POST['login'];
        $pw = password_hash($_POST['pw'], PASSWORD_DEFAULT);

        try {
            if (empty($fullname) || empty($login) || empty($pw)) {
                throw new Exception("None of the values can be empty.");
            }

            $request = new mysqli_request();
            $result = $request->sign_up($fullname, $login, $pw);
            
            $rc = new success_code("You was successfully signed-up.", array(
                'fullname' => htmlspecialchars($fullname), 
                'login' => htmlspecialchars($login), 
                'pw' => htmlspecialchars($pw), 
                'id' => $result)
            );
        }
        catch (Exception $e) {
            $rc = new error_code(htmlspecialchars($e->getMessage()));
        }
    }