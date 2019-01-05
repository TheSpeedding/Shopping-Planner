<?php
    if (isset($_GET['logout'])) {
        session_unset();
        session_destroy();
        setcookie("session", '');
        setcookie("last_visited_list", '');
        header("Location: index.php");
        exit();
    }

    else if (isset($_SESSION['login']) && isset($_SESSION['name'])) {
        header("Location: main.php");
        exit();
    }

    else if (isset($_POST['controller'])) {

        $controller = $_POST['controller'];

        $rc = NULL;

        include(__DIR__ . "/controllers/controller.php"); // Executes the controller.

        if ($rc instanceof success_code) {
            if ($controller == "login") {
                header("Location: main.php");
                exit();
            }

            else if ($controller == "signup") {
                header("Location: index.php?action=" . urlencode($controller) . "&type=success&message=". urlencode($rc->getMessage())); 
                exit();
            }

            else {
                die("Invalid controller.");
            }
        }

        else if ($rc instanceof error_code) {
            header("Location: index.php?action=" . urlencode($controller) . "&type=error&message=". urlencode($rc->getMessage()));
            exit();
        }

        else {
            die("Invalid return code.");
        }
    }