<?php
    if (isset($_GET['logout'])) {
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit();
    }

    else if (isset($_POST['controller'])) {

        $controller = $_POST['controller'];

        try {

            include("controllers/controller_base.php"); // Executes the controller.

            if ($controller == "login") {
                header("Location: main.php?session=" . session_id());
                exit();
            }
            else {
                header("Location: index.php?action=${controller}&type=success&message='". urlencode($rc) . "'"); 
                exit();
            }                  
        }

        catch (Exception $e) {
            header("Location: index.php?action=${controller}&type=error&message='". urlencode($e->getMessage()) . "'");
            exit();
        }

    }