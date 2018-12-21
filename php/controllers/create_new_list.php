<?php   
    include_once(__DIR__ . '/controller.php');

    if (!isset($_SESSION['login'])) {
        $rc = new error_code("Session has expired.");
    }

    else if (!isset($_POST['name'])) {
        $rc = new error_code("Missing parameters.");
    }

    else {
        $login = $_SESSION['login'];
        $name = htmlspecialchars($_POST['name']);    
        
        try {
            if (empty($name)) {
                throw new Exception("None of the values can be empty.");
            }
            
            $request = new mysqli_request();
            $result = $request->create_new_list($name, $login);
            $rc = new success_code("New list created successfully.", array('name' => $name, 'login' => $login, 'id' => $result));
        }
        catch (Exception $e) {
            $rc = new error_code(htmlspecialchars($e->getMessage()));
        }
    }