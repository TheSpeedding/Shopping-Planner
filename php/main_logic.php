<?php
    if (!isset($_SESSION['name']) || !isset($_SESSION['login'])) {
        header("Location: index.php?action=login&type=error&message='". urlencode("Your session has expired. Log-in again, please.") . "'");  
        exit();
    }
    
    else if (isset($_POST['controller'])) {

        $controller = $_POST['controller'];

        $rc = NULL;

        include(__DIR__ . "/controllers/controller.php"); // Executes the controller.

        if ($rc instanceof success_code) {
            // This block is reached when the addition to the list was successful. Do not show the message -> the user will see the item was added anyway.
            header("Location: main.php"/*?action=list&type=success&message='". urlencode($rc->getMessage()) . "'&fade"*/); 
            exit();
        }

        else if ($rc instanceof error_code) {
            header("Location: main.php?action=list&type=error&message='". urlencode($rc->getMessage()) . "'&fade");
            exit();
        }

        else {
            die("Invalid return code.");
        }
    }