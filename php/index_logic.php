<?php
    if (isset($_GET['logout'])) {
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit();
    }

    else if (isset($_POST['controller'])) {

        $controller = $_POST['controller'];

        $rc = NULL;

        include(__DIR__ . "/controllers/controller.php"); // Executes the controller.

        if ($rc instanceof success_code) {
            if ($controller == "login") {
                header("Location: main.php?session=" . session_id());
                exit();
            }

            else if ($controller == "signup") {
                header("Location: index.php?action=${controller}&type=success&message='". urlencode($rc->success) . "'"); 
                exit();
            }

            else {
                die("Invalid controller.");
            }
        }

        else if ($rc instanceof error_code) {
            header("Location: index.php?action=${controller}&type=error&message='". urlencode($rc->error) . "'");
        }

        else {
            die("Invalid return code.");
        }
    }